<?php

namespace App\Services\Payment\DataObjects;

class WebhookResult
{
    public function __construct(
        public bool $valid,
        public ?string $orderId = null,
        public ?string $gatewayTransactionId = null,
        public ?string $status = null, // completed, failed, refunded, disputed, etc.
        public ?float $amount = null,
        public ?string $eventType = null,
        public array $rawPayload = []
    ) {}

    public static function make(
        bool $valid,
        ?string $orderId = null,
        ?string $gatewayTransactionId = null,
        ?string $status = null,
        ?float $amount = null,
        ?string $eventType = null,
        array $rawPayload = []
    ): self {
        return new self($valid, $orderId, $gatewayTransactionId, $status, $amount, $eventType, $rawPayload);
    }
}
