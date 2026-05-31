<?php

namespace App\Services\Payment\DataObjects;

class PaymentResponse
{
    public function __construct(
        public bool $success,
        public string $status, // pending, completed, failed, processing
        public ?string $transactionId = null,
        public ?string $redirectUrl = null,
        public ?string $errorMessage = null,
        public array $rawPayload = []
    ) {}

    public static function make(
        bool $success,
        string $status,
        ?string $transactionId = null,
        ?string $redirectUrl = null,
        ?string $errorMessage = null,
        array $rawPayload = []
    ): self {
        return new self($success, $status, $transactionId, $redirectUrl, $errorMessage, $rawPayload);
    }
}
