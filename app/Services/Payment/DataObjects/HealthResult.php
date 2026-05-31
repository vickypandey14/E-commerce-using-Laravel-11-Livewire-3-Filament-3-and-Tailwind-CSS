<?php

namespace App\Services\Payment\DataObjects;

class HealthResult
{
    public function __construct(
        public bool $healthy,
        public string $message,
        public int $latencyMs = 0
    ) {}

    public static function make(bool $healthy, string $message, int $latencyMs = 0): self
    {
        return new self($healthy, $message, $latencyMs);
    }
}
