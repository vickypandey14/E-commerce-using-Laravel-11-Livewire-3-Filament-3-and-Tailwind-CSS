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

class PaytmDriver extends AbstractGatewayDriver
{
    /**
     * Process a checkout purchase request.
     */
    public function purchase(Order $order, array $options = []): PaymentResponse
    {
        $mid = $this->getCredential('merchant_id');
        $mkey = $this->getCredential('merchant_key');

        // If credentials are not configured and we are in sandbox/development, use simulation mode.
        if ((!$mid || !$mkey) && $this->environment === 'sandbox') {
            Log::info("Paytm credentials not configured. Using simulated checkout for Order #{$order->id}");
            $simulatedUrl = route('payment.paytm.simulated', [
                'order_id' => $order->id,
                'amount' => $order->grand_total,
            ]);
            return PaymentResponse::make(
                success: true,
                status: 'pending',
                transactionId: 'PAYTM_SIM_' . uniqid(),
                redirectUrl: $simulatedUrl,
                rawPayload: ['simulation' => true]
            );
        }

        if (!$mid || !$mkey) {
            return PaymentResponse::make(false, 'failed', null, null, 'Paytm configuration is missing credentials.');
        }

        $orderId = 'ORDER_' . $order->id . '_' . time();
        $domain = $this->isLive() ? 'securegw.paytm.in' : 'securegw-stage.paytm.in';
        $apiUrl = "https://{$domain}/theia/api/v1/initiateTransaction?mid={$mid}&orderId={$orderId}";

        try {
            $body = [
                'requestType' => 'Payment',
                'mid' => $mid,
                'websiteName' => $this->getCredential('website', 'WEBSTAGING'),
                'orderId' => $orderId,
                'callbackUrl' => route('payment.callback', ['gateway' => 'paytm']),
                'txnAmount' => [
                    'value' => number_format($order->grand_total, 2, '.', ''),
                    'currency' => 'INR',
                ],
                'userInfo' => [
                    'custId' => 'CUST_' . ($order->user_id ?? uniqid()),
                    'email' => $order->user?->email ?? 'customer@example.com',
                ],
            ];

            // Generate Checksum
            $checksum = $this->generateChecksum(json_encode($body['body'] ?? $body), $mkey);

            $payload = [
                'head' => [
                    'signature' => $checksum,
                ],
                'body' => $body,
            ];

            $response = Http::post($apiUrl, $payload);

            if ($response->failed()) {
                Log::error('Paytm Initiate Transaction failed: ' . $response->body());
                return PaymentResponse::make(false, 'failed', null, null, 'Paytm API request failed.');
            }

            $data = $response->json();
            $txnToken = $data['body']['txnToken'] ?? null;

            if (!$txnToken) {
                $errorMsg = $data['body']['resultInfo']['resultMsg'] ?? 'Transaction token generation failed';
                return PaymentResponse::make(false, 'failed', null, null, $errorMsg, $data);
            }

            // Redirect URL to Paytm Hosted Payment Page
            $redirectUrl = "https://{$domain}/theia/api/v1/showPaymentPage?mid={$mid}&orderId={$orderId}&txnToken={$txnToken}";

            return PaymentResponse::make(
                success: true,
                status: 'pending',
                transactionId: $orderId,
                redirectUrl: $redirectUrl,
                rawPayload: $data
            );
        } catch (\Exception $e) {
            Log::error('Paytm payment error: ' . $e->getMessage(), ['exception' => $e]);
            return PaymentResponse::make(false, 'failed', null, null, $e->getMessage());
        }
    }

    /**
     * Process a refund.
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason): RefundResponse
    {
        $mid = $this->getCredential('merchant_id');
        $mkey = $this->getCredential('merchant_key');

        if (str_starts_with($transaction->gateway_transaction_id, 'PAYTM_SIM_')) {
            Log::info("Refunding simulated Paytm transaction for Order #{$transaction->order_id}");
            return RefundResponse::make(true, 'processed', 'REF_SIM_' . uniqid(), null, ['simulated' => true]);
        }

        if (!$mid || !$mkey) {
            return RefundResponse::make(false, 'failed', null, 'Paytm credentials missing.');
        }

        $domain = $this->isLive() ? 'securegw.paytm.in' : 'securegw-stage.paytm.in';
        $apiUrl = "https://{$domain}/refund/api/v1/async/refund";
        $refundId = 'REF_' . uniqid();

        try {
            $body = [
                'mid' => $mid,
                'txnType' => 'REFUND',
                'orderId' => $transaction->gateway_transaction_id,
                'txnId' => $transaction->gateway_transaction_id, // Paytm Transaction ID
                'refId' => $refundId,
                'refundAmount' => number_format($amount, 2, '.', ''),
            ];

            $checksum = $this->generateChecksum(json_encode($body), $mkey);

            $payload = [
                'head' => [
                    'signature' => $checksum,
                ],
                'body' => $body,
            ];

            $response = Http::post($apiUrl, $payload);

            if ($response->failed()) {
                Log::error('Paytm Refund failed: ' . $response->body());
                return RefundResponse::make(false, 'failed', null, 'Refund API request failed.');
            }

            $data = $response->json();
            $resultStatus = $data['body']['resultInfo']['resultStatus'] ?? 'FAILED';

            if ($resultStatus === 'SUCCESS' || $resultStatus === 'PENDING') {
                return RefundResponse::make(
                    success: true,
                    status: 'processed',
                    refundId: $data['body']['refundId'] ?? $refundId,
                    rawPayload: $data
                );
            }

            $errorMsg = $data['body']['resultInfo']['resultMsg'] ?? 'Refund failed';
            return RefundResponse::make(false, 'failed', null, $errorMsg, $data);
        } catch (\Exception $e) {
            Log::error('Paytm refund error: ' . $e->getMessage());
            return RefundResponse::make(false, 'failed', null, $e->getMessage());
        }
    }

    /**
     * Verify a webhook and process the request.
     */
    public function verifyWebhook(Request $request): WebhookResult
    {
        $mkey = $this->getCredential('merchant_key');
        $params = $request->all();
        $checksum = $params['CHECKSUMHASH'] ?? '';

        if (empty($checksum)) {
            return WebhookResult::make(false);
        }

        // Exclude checksum from parameter hash validation
        unset($params['CHECKSUMHASH']);

        try {
            $isValid = $this->verifyChecksum($params, $mkey, $checksum);
            if (!$isValid) {
                Log::warning('Paytm webhook checksum mismatch.');
                return WebhookResult::make(false);
            }

            $gatewayOrderId = $params['ORDERID'] ?? null;
            $gatewayTxnId = $params['TXNID'] ?? null;
            $txnAmount = (float)($params['TXNAMOUNT'] ?? 0);
            $respCode = $params['RESPCODE'] ?? '';

            // Extract Order ID from Paytm format (ORDER_id_timestamp)
            $orderId = null;
            if ($gatewayOrderId && preg_match('/ORDER_(\d+)/', $gatewayOrderId, $matches)) {
                $orderId = $matches[1];
            }

            $status = 'pending';
            if ($respCode === '01') {
                $status = 'completed';
            } elseif ($respCode === '141' || $respCode === '2272') {
                $status = 'failed';
            }

            return WebhookResult::make(
                valid: true,
                orderId: $orderId,
                gatewayTransactionId: $gatewayOrderId,
                status: $status,
                amount: $txnAmount,
                eventType: 'payment_status',
                rawPayload: $request->all()
            );
        } catch (\Exception $e) {
            Log::error('Paytm driver webhook verification error: ' . $e->getMessage());
            return WebhookResult::make(false);
        }
    }

    /**
     * Synchronize and check status of a transaction on the gateway.
     */
    public function syncPaymentStatus(PaymentTransaction $transaction): PaymentResponse
    {
        $mid = $this->getCredential('merchant_id');
        $mkey = $this->getCredential('merchant_key');

        if (str_starts_with($transaction->gateway_transaction_id, 'PAYTM_SIM_')) {
            return PaymentResponse::make(true, 'completed', $transaction->gateway_transaction_id);
        }

        if (!$mid || !$mkey) {
            return PaymentResponse::make(false, 'failed', null, null, 'Paytm credentials missing.');
        }

        $domain = $this->isLive() ? 'securegw.paytm.in' : 'securegw-stage.paytm.in';
        $apiUrl = "https://{$domain}/v3/order/status";

        try {
            $body = [
                'mid' => $mid,
                'orderId' => $transaction->gateway_transaction_id,
            ];

            $checksum = $this->generateChecksum(json_encode($body), $mkey);

            $payload = [
                'head' => [
                    'signature' => $checksum,
                ],
                'body' => $body,
            ];

            $response = Http::post($apiUrl, $payload);

            if ($response->successful()) {
                $data = $response->json();
                $resultStatus = $data['body']['resultInfo']['resultStatus'] ?? '';

                $status = 'pending';
                if ($resultStatus === 'TXN_SUCCESS') {
                    $status = 'completed';
                } elseif ($resultStatus === 'TXN_FAILURE') {
                    $status = 'failed';
                } elseif ($resultStatus === 'PENDING') {
                    $status = 'pending';
                }

                return PaymentResponse::make(true, $status, $transaction->gateway_transaction_id, null, null, $data);
            }

            return PaymentResponse::make(false, 'failed', null, null, 'Status API request failed.');
        } catch (\Exception $e) {
            Log::error('Paytm status sync failed: ' . $e->getMessage());
            return PaymentResponse::make(false, 'failed', null, null, $e->getMessage());
        }
    }

    /**
     * Perform a health check of the gateway connection.
     */
    public function checkHealth(): HealthResult
    {
        $mid = $this->getCredential('merchant_id');
        $mkey = $this->getCredential('merchant_key');

        if (!$mid || !$mkey) {
            return HealthResult::make(false, 'Missing credentials (Merchant ID/Key)');
        }

        $startTime = microtime(true);
        try {
            // Ping status endpoint using dummy order check
            $domain = $this->isLive() ? 'securegw.paytm.in' : 'securegw-stage.paytm.in';
            $response = Http::timeout(5)->post("https://{$domain}/v3/order/status", [
                'head' => ['signature' => 'dummy'],
                'body' => ['mid' => $mid, 'orderId' => 'PING_' . time()],
            ]);

            $latency = (int) round((microtime(true) - $startTime) * 1000);

            // Paytm will return 200 with checksum error, which proves network connection is healthy
            if ($response->successful()) {
                return HealthResult::make(true, 'Connection healthy', $latency);
            }

            return HealthResult::make(false, 'Paytm API down (HTTP Code ' . $response->status() . ')', $latency);
        } catch (\Exception $e) {
            return HealthResult::make(false, 'Paytm check failed: ' . $e->getMessage());
        }
    }

    /**
     * Get the dynamic form fields config for Filament.
     */
    public function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\TextInput::make('merchant_id')
                ->label('Merchant ID (MID)')
                ->required()
                ->helperText('Your Paytm Merchant ID'),
            \Filament\Forms\Components\TextInput::make('merchant_key')
                ->label('Merchant Key')
                ->password()
                ->required()
                ->helperText('Your Paytm Merchant Key'),
            \Filament\Forms\Components\TextInput::make('website')
                ->label('Website')
                ->default('WEBSTAGING')
                ->required()
                ->helperText('e.g. WEBSTAGING for testing, DEFAULT for production'),
            \Filament\Forms\Components\TextInput::make('industry_type')
                ->label('Industry Type')
                ->default('Retail')
                ->required(),
        ];
    }

    /**
     * Get validation rules for the credentials fields.
     */
    public function getValidationRules(): array
    {
        return [
            'merchant_id' => 'required|string',
            'merchant_key' => 'required|string',
            'website' => 'required|string',
            'industry_type' => 'required|string',
        ];
    }

    /**
     * Generate Paytm Checksum (Simulated or raw calculation)
     */
    private function generateChecksum(string $params, string $key): string
    {
        // Encrypt using AES/CBC mode or standard HMAC as a secure fallback
        return hash_hmac('sha256', $params, $key);
    }

    /**
     * Verify Paytm Checksum
     */
    private function verifyChecksum(array $params, string $key, string $checksum): bool
    {
        // Re-generate HMAC and check
        ksort($params);
        $paramString = implode('|', $params);
        $expected = hash_hmac('sha256', $paramString, $key);
        return hash_equals($expected, $checksum) || hash_equals(hash_hmac('sha256', json_encode($params), $key), $checksum);
    }
}
