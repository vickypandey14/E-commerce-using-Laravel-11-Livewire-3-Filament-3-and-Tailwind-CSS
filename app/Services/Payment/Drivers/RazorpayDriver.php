<?php

namespace App\Services\Payment\Drivers;

use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Services\Payment\DataObjects\PaymentResponse;
use App\Services\Payment\DataObjects\RefundResponse;
use App\Services\Payment\DataObjects\WebhookResult;
use App\Services\Payment\DataObjects\HealthResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RazorpayDriver extends AbstractGatewayDriver
{
    private const API_URL = 'https://api.razorpay.com/v1';

    /**
     * Process a checkout purchase request.
     */
    public function purchase(Order $order, array $options = []): PaymentResponse
    {
        $keyId = $this->getCredential('key_id');
        $keySecret = $this->getCredential('key_secret');

        if (!$keyId || !$keySecret) {
            return PaymentResponse::make(false, 'failed', null, null, 'Razorpay configuration is missing keys.');
        }

        // Amount in paise
        $amount = (int) round($order->grand_total * 100);
        $currency = strtoupper($order->currency ?? 'INR');

        try {
            $response = Http::withBasicAuth($keyId, $keySecret)
                ->post(self::API_URL . '/orders', [
                    'amount' => $amount,
                    'currency' => $currency,
                    'receipt' => 'receipt_order_' . $order->id,
                    'notes' => [
                        'order_id' => $order->id,
                        'customer_name' => auth()->user()?->name ?? 'Guest',
                    ]
                ]);

            if ($response->failed()) {
                $error = $response->json()['error']['description'] ?? 'Razorpay Order API failed';
                Log::error('Razorpay order creation failed: ' . $response->body());
                return PaymentResponse::make(false, 'failed', null, null, $error, $response->json() ?? []);
            }

            $data = $response->json();
            $razorpayOrderId = $data['id'];

            // Return redirect to local page that renders the Razorpay modal checkout
            $redirectUrl = route('payment.razorpay.checkout', [
                'order_id' => $order->id,
                'razorpay_order_id' => $razorpayOrderId,
            ]);

            return PaymentResponse::make(
                success: true,
                status: 'pending',
                transactionId: $razorpayOrderId,
                redirectUrl: $redirectUrl,
                rawPayload: $data
            );
        } catch (\Exception $e) {
            Log::error('Razorpay driver payment error: ' . $e->getMessage(), ['exception' => $e]);
            return PaymentResponse::make(false, 'failed', null, null, $e->getMessage());
        }
    }

    /**
     * Process a refund.
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason): RefundResponse
    {
        $keyId = $this->getCredential('key_id');
        $keySecret = $this->getCredential('key_secret');

        if (!$keyId || !$keySecret) {
            return RefundResponse::make(false, 'failed', null, 'Razorpay credentials missing.');
        }

        $amountInPaise = (int) round($amount * 100);

        try {
            // Find the actual payment ID. If transaction ID is order ID, we search payments for this order.
            $paymentId = $transaction->gateway_transaction_id;

            // If transaction ID is an order ID (begins with order_), we retrieve payments for this order first
            if (str_starts_with($paymentId, 'order_')) {
                $paymentId = $this->findPaymentIdFromOrderId($paymentId);
                if (!$paymentId) {
                    return RefundResponse::make(false, 'failed', null, 'Razorpay payment ID not found for Order ID.');
                }
            }

            $response = Http::withBasicAuth($keyId, $keySecret)
                ->post(self::API_URL . '/payments/' . $paymentId . '/refund', [
                    'amount' => $amountInPaise,
                    'notes' => [
                        'reason' => $reason,
                        'order_id' => $transaction->order_id,
                    ],
                ]);

            if ($response->failed()) {
                $error = $response->json()['error']['description'] ?? 'Razorpay Refund API failed';
                Log::error('Razorpay refund failed: ' . $response->body());
                return RefundResponse::make(false, 'failed', null, $error, $response->json() ?? []);
            }

            $data = $response->json();
            return RefundResponse::make(
                success: true,
                status: 'processed',
                refundId: $data['id'],
                rawPayload: $data
            );
        } catch (\Exception $e) {
            Log::error('Razorpay driver refund error: ' . $e->getMessage());
            return RefundResponse::make(false, 'failed', null, $e->getMessage());
        }
    }

    /**
     * Helper to find Razorpay payment ID from a Razorpay order ID.
     */
    private function findPaymentIdFromOrderId(string $orderId): ?string
    {
        $keyId = $this->getCredential('key_id');
        $keySecret = $this->getCredential('key_secret');

        $response = Http::withBasicAuth($keyId, $keySecret)
            ->get(self::API_URL . '/orders/' . $orderId . '/payments');

        if ($response->successful()) {
            $items = $response->json()['items'] ?? [];
            foreach ($items as $item) {
                if (($item['status'] ?? '') === 'captured') {
                    return $item['id'];
                }
            }
            return $items[0]['id'] ?? null;
        }

        return null;
    }

    /**
     * Verify a webhook and process the request.
     */
    public function verifyWebhook(Request $request): WebhookResult
    {
        $webhookSecret = $this->getCredential('webhook_secret');
        $signatureHeader = $request->header('X-Razorpay-Signature');

        if (!$signatureHeader) {
            return WebhookResult::make(false);
        }

        $payload = $request->getContent();

        try {
            // Verify HMAC-SHA256 signature
            $expectedSignature = hash_hmac('sha256', $payload, $webhookSecret);

            if (!hash_equals($expectedSignature, $signatureHeader)) {
                Log::warning('Razorpay webhook signature verification failed.');
                return WebhookResult::make(false);
            }

            $event = json_decode($payload, true);
            $eventType = $event['event'] ?? '';
            $payment = $event['payload']['payment']['entity'] ?? [];
            $orderEntity = $event['payload']['order']['entity'] ?? [];

            $status = 'pending';
            $gatewayTransactionId = $orderEntity['id'] ?? $payment['order_id'] ?? null;
            $orderId = $payment['notes']['order_id'] ?? $orderEntity['notes']['order_id'] ?? null;
            $amount = isset($payment['amount']) ? ($payment['amount'] / 100) : 0;

            if ($eventType === 'order.paid') {
                $status = 'completed';
            } elseif ($eventType === 'payment.failed') {
                $status = 'failed';
            } elseif ($eventType === 'refund.processed') {
                $status = 'refunded';
            }

            return WebhookResult::make(
                valid: true,
                orderId: $orderId,
                gatewayTransactionId: $gatewayTransactionId,
                status: $status,
                amount: $amount,
                eventType: $eventType,
                rawPayload: $event
            );
        } catch (\Exception $e) {
            Log::error('Razorpay driver webhook error: ' . $e->getMessage());
            return WebhookResult::make(false);
        }
    }

    /**
     * Synchronize and check status of a transaction on the gateway.
     */
    public function syncPaymentStatus(PaymentTransaction $transaction): PaymentResponse
    {
        $keyId = $this->getCredential('key_id');
        $keySecret = $this->getCredential('key_secret');

        if (!$keyId || !$keySecret) {
            return PaymentResponse::make(false, 'failed', null, null, 'Razorpay credentials missing.');
        }

        try {
            $gatewayId = $transaction->gateway_transaction_id;

            // If it's a Razorpay Order ID (starts with order_)
            if (str_starts_with($gatewayId, 'order_')) {
                $response = Http::withBasicAuth($keyId, $keySecret)
                    ->get(self::API_URL . '/orders/' . $gatewayId);

                if ($response->successful()) {
                    $order = $response->json();
                    $orderStatus = $order['status'] ?? '';
                    
                    $status = 'pending';
                    if ($orderStatus === 'paid') {
                        $status = 'completed';
                    } elseif ($orderStatus === 'attempted') {
                        $status = 'processing';
                    }
                    return PaymentResponse::make(true, $status, $gatewayId, null, null, $order);
                }
            } else {
                // It's a payment ID
                $response = Http::withBasicAuth($keyId, $keySecret)
                    ->get(self::API_URL . '/payments/' . $gatewayId);

                if ($response->successful()) {
                    $payment = $response->json();
                    $paymentStatus = $payment['status'] ?? '';
                    
                    $status = 'pending';
                    if ($paymentStatus === 'captured') {
                        $status = 'completed';
                    } elseif ($paymentStatus === 'failed') {
                        $status = 'failed';
                    } elseif ($paymentStatus === 'refunded') {
                        $status = 'refunded';
                    }
                    return PaymentResponse::make(true, $status, $gatewayId, null, null, $payment);
                }
            }

            return PaymentResponse::make(false, 'failed', null, null, 'Could not sync with Razorpay API');
        } catch (\Exception $e) {
            Log::error('Razorpay status sync failed: ' . $e->getMessage());
            return PaymentResponse::make(false, 'failed', null, null, $e->getMessage());
        }
    }

    /**
     * Perform a health check of the gateway connection.
     */
    public function checkHealth(): HealthResult
    {
        $keyId = $this->getCredential('key_id');
        $keySecret = $this->getCredential('key_secret');

        if (!$keyId || !$keySecret) {
            return HealthResult::make(false, 'Missing credentials (Key ID/Secret)');
        }

        $startTime = microtime(true);
        try {
            $response = Http::withBasicAuth($keyId, $keySecret)
                ->timeout(5)
                ->get(self::API_URL . '/orders', ['count' => 1]);

            $latency = (int) round((microtime(true) - $startTime) * 1000);

            if ($response->successful()) {
                return HealthResult::make(true, 'Connection healthy', $latency);
            }

            $errorMsg = $response->json()['error']['description'] ?? 'HTTP Code ' . $response->status();
            return HealthResult::make(false, 'Razorpay health check failed: ' . $errorMsg, $latency);
        } catch (\Exception $e) {
            return HealthResult::make(false, 'Razorpay check failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the dynamic form fields config for Filament.
     */
    public function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\TextInput::make('key_id')
                ->label('Key ID')
                ->required()
                ->helperText('Your Razorpay Key ID (starts with rzp_test_ or rzp_live_)'),
            \Filament\Forms\Components\TextInput::make('key_secret')
                ->label('Key Secret')
                ->password()
                ->required()
                ->helperText('Your Razorpay Key Secret'),
            \Filament\Forms\Components\TextInput::make('webhook_secret')
                ->label('Webhook Secret')
                ->password()
                ->required()
                ->helperText('Your webhook HMAC-SHA256 signature secret'),
        ];
    }

    /**
     * Get validation rules for the credentials fields.
     */
    public function getValidationRules(): array
    {
        return [
            'key_id' => 'required|string',
            'key_secret' => 'required|string',
            'webhook_secret' => 'required|string',
        ];
    }
}
