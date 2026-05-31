<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\PaymentGateway;
use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Exceptions\PaymentGatewayException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PaymentGatewayManager
{
    /**
     * Cache of resolved driver instances.
     */
    protected array $resolvedDrivers = [];

    /**
     * Resolve a payment gateway driver instance by code.
     */
    public function driver(?string $code = null): PaymentGatewayInterface
    {
        $code = $code ?: $this->getDefaultGatewayCode();

        if (isset($this->resolvedDrivers[$code])) {
            return $this->resolvedDrivers[$code];
        }

        $gateway = PaymentGateway::where('code', $code)->first();

        if (!$gateway) {
            // Check if fallback to config driver is possible (e.g. for default cod installation)
            $drivers = config('payment.drivers', []);
            if (array_key_exists($code, $drivers)) {
                $driverClass = $drivers[$code];
                return $this->resolvedDrivers[$code] = new $driverClass([], 'sandbox', []);
            }
            throw new PaymentGatewayException("Payment gateway driver [{$code}] is not configured in the database.");
        }

        $drivers = config('payment.drivers', []);
        $driverClass = $drivers[$gateway->driver] ?? null;

        if (!$driverClass || !class_exists($driverClass)) {
            throw new PaymentGatewayException("Payment gateway driver class for [{$gateway->driver}] is not registered.");
        }

        return $this->resolvedDrivers[$code] = new $driverClass(
            credentials: $gateway->credentials ?? [],
            environment: $gateway->environment ?? 'sandbox',
            settings: $gateway->settings ?? []
        );
    }

    /**
     * Get the default gateway code.
     */
    public function getDefaultGatewayCode(): string
    {
        $defaultGateway = PaymentGateway::active()->where('is_default', true)->first();
        
        return $defaultGateway 
            ? $defaultGateway->code 
            : config('payment.default', 'cod');
    }

    /**
     * Get all active payment gateways sorted by priority.
     */
    public function getActiveGateways(): Collection
    {
        return PaymentGateway::active()->orderBy('priority', 'asc')->get();
    }

    /**
     * Route order to a fallback gateway when the primary gateway fails.
     */
    public function fallbackRoute(string $failedGatewayCode, Order $order, array $options = []): ?DataObjects\PaymentResponse
    {
        Log::warning("Fallback mechanism triggered. Gateway [{$failedGatewayCode}] failed for Order #{$order->id}");

        $activeGateways = $this->getActiveGateways();
        $fallbackGateway = $activeGateways->filter(function ($gateway) use ($failedGatewayCode) {
            return $gateway->code !== $failedGatewayCode && $gateway->health_status !== 'down';
        })->first();

        if (!$fallbackGateway) {
            Log::critical("Fallback failed: No alternative healthy payment gateway available for Order #{$order->id}");
            return null;
        }

        Log::info("Routing Order #{$order->id} from failed [{$failedGatewayCode}] to fallback [{$fallbackGateway->code}]");

        try {
            $driver = $this->driver($fallbackGateway->code);
            $response = $driver->purchase($order, $options);

            // Update order payment method to reflect fallback
            $order->update([
                'payment_method' => $fallbackGateway->code,
                'notes' => ($order->notes ? $order->notes . ' ' : '') . "[Fallback routed from {$failedGatewayCode}]",
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error("Fallback routing to [{$fallbackGateway->code}] failed: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Run health check for a given gateway and update status.
     */
    public function syncHealth(string $code): DataObjects\HealthResult
    {
        $gateway = PaymentGateway::where('code', $code)->first();
        if (!$gateway) {
            return DataObjects\HealthResult::make(false, 'Gateway does not exist');
        }

        try {
            $driver = $this->driver($code);
            $result = $driver->checkHealth();

            $status = $result->healthy ? 'healthy' : 'down';
            $gateway->update([
                'health_status' => $status,
                'last_health_check_at' => now(),
            ]);

            return $result;
        } catch (\Exception $e) {
            $gateway->update([
                'health_status' => 'down',
                'last_health_check_at' => now(),
            ]);
            return DataObjects\HealthResult::make(false, $e->getMessage());
        }
    }
}
