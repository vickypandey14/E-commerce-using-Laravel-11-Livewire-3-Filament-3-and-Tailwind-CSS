<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Cash on Delivery Gateway (Default)
        PaymentGateway::updateOrCreate(
            ['code' => 'cod'],
            [
                'name' => 'Cash on Delivery',
                'driver' => 'cod',
                'is_active' => true,
                'environment' => 'sandbox',
                'priority' => 10,
                'is_default' => true,
                'credentials' => [],
                'settings' => [],
                'health_status' => 'healthy',
            ]
        );

        // 2. Stripe Gateway
        PaymentGateway::updateOrCreate(
            ['code' => 'stripe'],
            [
                'name' => 'Stripe Card Checkout',
                'driver' => 'stripe',
                'is_active' => true,
                'environment' => 'sandbox',
                'priority' => 1,
                'is_default' => false,
                'credentials' => [
                    'secret_key' => 'sk_test_placeholder_key_value_for_sandbox',
                    'publishable_key' => 'pk_test_placeholder_key_value_for_sandbox',
                    'webhook_secret' => 'whsec_placeholder_key_value_for_sandbox',
                ],
                'settings' => [],
                'health_status' => 'unknown',
            ]
        );

        // 3. Razorpay Gateway
        PaymentGateway::updateOrCreate(
            ['code' => 'razorpay'],
            [
                'name' => 'Razorpay Payment',
                'driver' => 'razorpay',
                'is_active' => true,
                'environment' => 'sandbox',
                'priority' => 2,
                'is_default' => false,
                'credentials' => [
                    'key_id' => 'rzp_test_placeholder_key_value_for_sandbox',
                    'key_secret' => 'rzp_secret_placeholder_key_value_for_sandbox',
                    'webhook_secret' => 'rzp_webhook_placeholder_key_value_for_sandbox',
                ],
                'settings' => [],
                'health_status' => 'unknown',
            ]
        );

        // 4. Paytm Gateway
        PaymentGateway::updateOrCreate(
            ['code' => 'paytm'],
            [
                'name' => 'Paytm Wallet & UPI',
                'driver' => 'paytm',
                'is_active' => true,
                'environment' => 'sandbox',
                'priority' => 3,
                'is_default' => false,
                'credentials' => [
                    'merchant_id' => '',
                    'merchant_key' => '',
                    'website' => 'WEBSTAGING',
                    'industry_type' => 'Retail',
                ],
                'settings' => [],
                'health_status' => 'unknown',
            ]
        );
    }
}
