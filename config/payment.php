<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | This option controls the default payment gateway driver that will be used
    | if no gateway code is explicitly specified.
    |
    */

    'default' => env('PAYMENT_DEFAULT_GATEWAY', 'cod'),

    /*
    |--------------------------------------------------------------------------
    | Registered Payment Gateway Drivers
    |--------------------------------------------------------------------------
    |
    | Define the map of driver keys to their corresponding driver classes.
    | New drivers can be added here without modifying existing business logic.
    |
    */

    'drivers' => [
        'stripe' => \App\Services\Payment\Drivers\StripeDriver::class,
        'razorpay' => \App\Services\Payment\Drivers\RazorpayDriver::class,
        'paytm' => \App\Services\Payment\Drivers\PaytmDriver::class,
        'cod' => \App\Services\Payment\Drivers\CodDriver::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Automatic Retry & Fallback Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for transaction automatic retries and fallback gateway routing
    | when a provider fails.
    |
    */

    'fallback' => [
        'enabled' => true,
        'max_retries' => 3,
        'retry_delay_seconds' => 10,
    ],
];
