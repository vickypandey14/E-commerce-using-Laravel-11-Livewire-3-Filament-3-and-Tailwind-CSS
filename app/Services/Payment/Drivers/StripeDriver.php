<?php

namespace App\Services\Payment\Drivers;

use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Services\Payment\DataObjects\PaymentResponse;
use App\Services\Payment\DataObjects\RefundResponse;
use App\Services\Payment\DataObjects\WebhookResult;
use App\Services\Payment\DataObjects\HealthResult;
use App\Services\Payment\Exceptions\PaymentGatewayException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StripeDriver extends AbstractGatewayDriver
{
    private const API_URL = 'https://api.stripe.com/v1';

    /**
     * Process a checkout purchase request.
     */
    public function purchase(Order $order, array $options = []): PaymentResponse
    {
        $secretKey = $this->getCredential('secret_key');
        if (!$secretKey) {
            return PaymentResponse::make(false, 'failed', null, null, 'Stripe configuration is missing secret key.');
        }

        // Amount in cents
        $amount = (int) round($order->grand_total * 100);
        $currency = strtolower($order->currency ?? 'inr');

        try {
            $response = Http::asForm()
                ->withBasicAuth($secretKey, '')
                ->post(self::API_URL . '/checkout/sessions', [
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => $currency,
                                'product_data' => [
                                    'name' => 'Order #' . $order->id . ' Payment',
                                    'metadata' => [
                                        'order_id' => $order->id,
                                    ],
                                ],
                                'unit_amount' => $amount,
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'mode' => 'payment',
                    'success_url' => route('payment.callback', ['gateway' => 'stripe']) . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
                    'cancel_url' => route('payment.cancel', ['order_id' => $order->id]),
                    'metadata' => [
                        'order_id' => $order->id,
                    ],
                    'payment_intent_data' => [
                        'metadata' => [
                            'order_id' => $order->id,
                        ],
                    ],
                ]);

            if ($response->failed()) {
                $error = $response->json()['error']['message'] ?? 'Stripe API call failed';
                Log::error('Stripe payment session creation failed: ' . $response->body());
                return PaymentResponse::make(false, 'failed', null, null, $error, $response->json() ?? []);
            }

            $data = $response->json();
            return PaymentResponse::make(
                success: true,
                status: 'pending',
                transactionId: $data['id'],
                redirectUrl: $data['url'],
                rawPayload: $data
            );
        } catch (\Exception $e) {
            Log::error('Stripe driver payment error: ' . $e->getMessage(), ['exception' => $e]);
            return PaymentResponse::make(false, 'failed', null, null, $e->getMessage());
        }
    }

    /**
     * Process a refund.
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason): RefundResponse
    {
        $secretKey = $this->getCredential('secret_key');
        if (!$secretKey) {
            return RefundResponse::make(false, 'failed', null, 'Stripe configuration is missing secret key.');
        }

        $amountInCents = (int) round($amount * 100);

        try {
            // First we need to find the Charge ID or Payment Intent ID.
            // If the transaction ID is a checkout session ID (starts with cs_), we need to retrieve the session
            // to find the payment intent ID.
            $gatewayId = $transaction->gateway_transaction_id;
            if (str_starts_with($gatewayId, 'cs_')) {
                $sessionResp = Http::withBasicAuth($secretKey, '')
                    ->get(self::API_URL . '/checkout/sessions/' . $gatewayId);
                if ($sessionResp->successful()) {
                    $gatewayId = $sessionResp->json()['payment_intent'] ?? $gatewayId;
                }
            }

            $response = Http::asForm()
                ->withBasicAuth($secretKey, '')
                ->post(self::API_URL . '/refunds', [
                    'payment_intent' => $gatewayId,
                    'amount' => $amountInCents,
                    'reason' => 'requested_by_customer',
                    'metadata' => [
                        'reason_text' => $reason,
                        'order_id' => $transaction->order_id,
                    ],
                ]);

            if ($response->failed()) {
                $error = $response->json()['error']['message'] ?? 'Stripe refund failed';
                Log::error('Stripe refund creation failed: ' . $response->body());
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
            Log::error('Stripe driver refund error: ' . $e->getMessage(), ['exception' => $e]);
            return RefundResponse::make(false, 'failed', null, $e->getMessage());
        }
    }

    /**
     * Verify a webhook and process the request.
     */
    public function verifyWebhook(Request $request): WebhookResult
    {
        $webhookSecret = $this->getCredential('webhook_secret');
        $signatureHeader = $request->header('Stripe-Signature');

        if (!$signatureHeader) {
            return WebhookResult::make(false);
        }

        $payload = $request->getContent();

        // Standard Stripe Signature Verification:
        // Format of header: t=1492774577,v1=52571869cdf3396c25a4569c92b7276ecb90...
        try {
            $parts = explode(',', $signatureHeader);
            $timestamp = null;
            $signatures = [];

            foreach ($parts as $part) {
                $subparts = explode('=', $part, 2);
                if (count($subparts) === 2) {
                    if (trim($subparts[0]) === 't') {
                        $timestamp = trim($subparts[1]);
                    } elseif (trim($subparts[0]) === 'v1') {
                        $signatures[] = trim($subparts[1]);
                    }
                }
            }

            if (!$timestamp || empty($signatures)) {
                return WebhookResult::make(false);
            }

            // Check tolerance (e.g. 5 minutes / 300 seconds)
            if (abs(time() - (int)$timestamp) > 300) {
                Log::warning('Stripe webhook verification failed: timestamp tolerance exceeded.');
                return WebhookResult::make(false);
            }

            $signedPayload = $timestamp . '.' . $payload;
            $expectedSignature = hash_hmac('sha256', $signedPayload, $webhookSecret);

            $matched = false;
            foreach ($signatures as $sig) {
                if (hash_equals($expectedSignature, $sig)) {
                    $matched = true;
                    break;
                }
            }

            if (!$matched) {
                Log::warning('Stripe webhook signature match failed.');
                return WebhookResult::make(false);
            }

            // Successfully verified! Let's extract values
            $event = json_decode($payload, true);
            $eventType = $event['type'] ?? '';
            $object = $event['data']['object'] ?? [];

            $status = 'pending';
            $gatewayTransactionId = null;
            $orderId = null;
            $amount = null;

            if ($eventType === 'checkout.session.completed') {
                $status = 'completed';
                $gatewayTransactionId = $object['id'];
                $orderId = $object['metadata']['order_id'] ?? null;
                $amount = $object['amount_total'] / 100;
            } elseif ($eventType === 'charge.refunded') {
                $status = 'refunded';
                $gatewayTransactionId = $object['payment_intent'] ?? null;
                $orderId = $object['metadata']['order_id'] ?? null;
                $amount = $object['amount_refunded'] / 100;
            } elseif ($eventType === 'charge.failed') {
                $status = 'failed';
                $gatewayTransactionId = $object['payment_intent'] ?? null;
                $orderId = $object['metadata']['order_id'] ?? null;
                $amount = $object['amount'] / 100;
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
            Log::error('Stripe driver webhook error: ' . $e->getMessage());
            return WebhookResult::make(false);
        }
    }

    /**
     * Synchronize and check status of a transaction on the gateway.
     */
    public function syncPaymentStatus(PaymentTransaction $transaction): PaymentResponse
    {
        $secretKey = $this->getCredential('secret_key');
        if (!$secretKey) {
            return PaymentResponse::make(false, 'failed', null, null, 'Stripe secret key missing.');
        }

        try {
            $gatewayId = $transaction->gateway_transaction_id;
            if (str_starts_with($gatewayId, 'cs_')) {
                // Checkout Session status
                $response = Http::withBasicAuth($secretKey, '')
                    ->get(self::API_URL . '/checkout/sessions/' . $gatewayId);
                
                if ($response->successful()) {
                    $session = $response->json();
                    $paymentStatus = $session['payment_status'] ?? '';
                    $status = 'pending';
                    if ($paymentStatus === 'paid') {
                        $status = 'completed';
                    } elseif ($paymentStatus === 'unpaid') {
                        $status = 'failed';
                    }
                    return PaymentResponse::make(true, $status, $gatewayId, null, null, $session);
                }
            } else {
                // Payment Intent status
                $response = Http::withBasicAuth($secretKey, '')
                    ->get(self::API_URL . '/payment_intents/' . $gatewayId);
                
                if ($response->successful()) {
                    $pi = $response->json();
                    $piStatus = $pi['status'] ?? '';
                    $status = 'pending';
                    if ($piStatus === 'succeeded') {
                        $status = 'completed';
                    } elseif ($piStatus === 'canceled' || $piStatus === 'requires_payment_method') {
                        $status = 'failed';
                    } elseif ($piStatus === 'processing') {
                        $status = 'processing';
                    }
                    return PaymentResponse::make(true, $status, $gatewayId, null, null, $pi);
                }
            }

            return PaymentResponse::make(false, 'failed', null, null, 'Could not sync with Stripe API');
        } catch (\Exception $e) {
            Log::error('Stripe status sync failed: ' . $e->getMessage());
            return PaymentResponse::make(false, 'failed', null, null, $e->getMessage());
        }
    }

    /**
     * Perform a health check of the gateway connection.
     */
    public function checkHealth(): HealthResult
    {
        $secretKey = $this->getCredential('secret_key');
        if (!$secretKey) {
            return HealthResult::make(false, 'Missing credentials (Secret Key)');
        }

        $startTime = microtime(true);
        try {
            $response = Http::withBasicAuth($secretKey, '')
                ->timeout(5)
                ->get(self::API_URL . '/balance');

            $latency = (int) round((microtime(true) - $startTime) * 1000);

            if ($response->successful()) {
                return HealthResult::make(true, 'Connection healthy', $latency);
            }

            $errorMsg = $response->json()['error']['message'] ?? 'HTTP Code ' . $response->status();
            return HealthResult::make(false, 'Stripe balance check failed: ' . $errorMsg, $latency);
        } catch (\Exception $e) {
            return HealthResult::make(false, 'Stripe check failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the dynamic form fields config for Filament.
     */
    public function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\TextInput::make('secret_key')
                ->label('Secret Key')
                ->password()
                ->required()
                ->helperText('Your Stripe secret key (starts with sk_test_ or sk_live_)'),
            \Filament\Forms\Components\TextInput::make('publishable_key')
                ->label('Publishable Key')
                ->required()
                ->helperText('Your Stripe publishable key (starts with pk_test_ or pk_live_)'),
            \Filament\Forms\Components\TextInput::make('webhook_secret')
                ->label('Webhook Signing Secret')
                ->password()
                ->required()
                ->helperText('Your webhook signature verification secret (starts with whsec_)'),
        ];
    }

    /**
     * Get validation rules for the credentials fields.
     */
    public function getValidationRules(): array
    {
        return [
            'secret_key' => 'required|string',
            'publishable_key' => 'required|string',
            'webhook_secret' => 'required|string',
        ];
    }
}
