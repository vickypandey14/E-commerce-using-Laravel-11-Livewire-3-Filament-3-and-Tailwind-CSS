<?php

namespace App\Services\Payment\Drivers;

use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Services\Payment\DataObjects\PaymentResponse;
use App\Services\Payment\DataObjects\RefundResponse;
use App\Services\Payment\DataObjects\WebhookResult;
use App\Services\Payment\DataObjects\HealthResult;
use Illuminate\Http\Request;

class CodDriver extends AbstractGatewayDriver
{
    /**
     * Process a checkout purchase request.
     */
    public function purchase(Order $order, array $options = []): PaymentResponse
    {
        // COD immediately succeeds order placing and marks status as pending payment.
        $successUrl = route('success', ['order_id' => $order->id]);

        return PaymentResponse::make(
            success: true,
            status: 'pending',
            transactionId: 'COD_' . uniqid(),
            redirectUrl: $successUrl
        );
    }

    /**
     * Process a refund.
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason): RefundResponse
    {
        return RefundResponse::make(
            success: true,
            status: 'processed',
            refundId: 'REF_COD_' . uniqid()
        );
    }

    /**
     * Verify a webhook and process the request.
     */
    public function verifyWebhook(Request $request): WebhookResult
    {
        return WebhookResult::make(false);
    }

    /**
     * Synchronize and check status of a transaction on the gateway.
     */
    public function syncPaymentStatus(PaymentTransaction $transaction): PaymentResponse
    {
        return PaymentResponse::make(true, $transaction->status, $transaction->gateway_transaction_id);
    }

    /**
     * Perform a health check of the gateway connection.
     */
    public function checkHealth(): HealthResult
    {
        return HealthResult::make(true, 'COD Gateway is active and functional.');
    }

    /**
     * Get the dynamic form fields config for Filament.
     */
    public function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Placeholder::make('instructions')
                ->label('Instructions')
                ->content('No credentials required. COD is an offline gateway driver.')
        ];
    }

    /**
     * Get validation rules for the credentials fields.
     */
    public function getValidationRules(): array
    {
        return [];
    }
}
