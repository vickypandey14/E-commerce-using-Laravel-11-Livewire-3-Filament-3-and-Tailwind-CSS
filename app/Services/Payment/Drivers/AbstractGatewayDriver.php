<?php

namespace App\Services\Payment\Drivers;

use App\Services\Payment\Contracts\PaymentGatewayInterface;

abstract class AbstractGatewayDriver implements PaymentGatewayInterface
{
    protected array $credentials = [];
    protected string $environment = 'sandbox';
    protected array $settings = [];

    public function __construct(array $credentials = [], string $environment = 'sandbox', array $settings = [])
    {
        $this->credentials = $credentials;
        $this->environment = $environment;
        $this->settings = $settings;
    }

    /**
     * Get a credential parameter with fallback support.
     */
    protected function getCredential(string $key, ?string $default = null): ?string
    {
        return $this->credentials[$key] ?? $default;
    }

    /**
     * Determine if we are running in production/live environment.
     */
    protected function isLive(): bool
    {
        return $this->environment === 'live';
    }

    /**
     * Get gateway-specific settings.
     */
    protected function getSetting(string $key, mixed $default = null): mixed
    {
        return $this->settings[$key] ?? $default;
    }
}
