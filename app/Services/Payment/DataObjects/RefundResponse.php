<?php

namespace App\Services\Payment\DataObjects;

class RefundResponse
{
    public function __construct(
        public bool $success,
        public string $status, // processed, failed
        public ?string $refundId = null,
        public ?string $errorMessage = null,
        public array $rawPayload = []
    ) {}

    public static function make(
        bool $success,
        string $status,
        ?string $refundId = null,
        ?string $errorMessage = null,
        array $rawPayload = []
    ): self {
        return new self($success, $status, $refundId, $errorMessage, $rawPayload);
    }
}
