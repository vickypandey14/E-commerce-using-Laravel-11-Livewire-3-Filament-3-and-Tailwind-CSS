<?php

namespace App\Services\Payment\Contracts;

use App\Models\Order;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use App\Services\Payment\DataObjects\PaymentResponse;
use App\Services\Payment\DataObjects\RefundResponse;
use App\Services\Payment\DataObjects\WebhookResult;
use App\Services\Payment\DataObjects\HealthResult;

interface PaymentGatewayInterface
{
    /**
     * Process a checkout purchase request.
     */
    public function purchase(Order $order, array $options = []): PaymentResponse;

    /**
     * Process a refund.
     */
    public function refund(PaymentTransaction $transaction, float $amount, string $reason): RefundResponse;

    /**
     * Verify a webhook and process the request.
     */
    public function verifyWebhook(Request $request): WebhookResult;

    /**
     * Synchronize and check status of a transaction on the gateway.
     */
    public function syncPaymentStatus(PaymentTransaction $transaction): PaymentResponse;

    /**
     * Perform a health check of the gateway connection.
     */
    public function checkHealth(): HealthResult;

    /**
     * Get the dynamic form fields config for Filament settings.
     */
    public function getFormSchema(): array;

    /**
     * Get validation rules for the credentials fields.
     */
    public function getValidationRules(): array;
}
