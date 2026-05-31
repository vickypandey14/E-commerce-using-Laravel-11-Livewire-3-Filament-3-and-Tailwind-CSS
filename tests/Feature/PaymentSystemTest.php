<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\PaymentGateway;
use App\Models\PaymentTransaction;
use App\Models\User;
use App\Services\Payment\PaymentGatewayManager;
use App\Services\Payment\Drivers\StripeDriver;
use App\Services\Payment\Drivers\RazorpayDriver;
use App\Services\Payment\Drivers\CodDriver;
use App\Events\PaymentReceived;
use App\Events\PaymentFailed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class PaymentSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Register default dummy active gateways
        PaymentGateway::create([
            'name' => 'Cash on Delivery',
            'code' => 'cod',
            'driver' => 'cod',
            'is_active' => true,
            'environment' => 'sandbox',
            'priority' => 10,
            'is_default' => true,
            'health_status' => 'healthy',
        ]);

        PaymentGateway::create([
            'name' => 'Stripe Card',
            'code' => 'stripe',
            'driver' => 'stripe',
            'is_active' => true,
            'environment' => 'sandbox',
            'priority' => 1,
            'is_default' => false,
            'credentials' => [
                'secret_key' => 'sk_test_mock_secret',
                'publishable_key' => 'pk_test_mock_pub',
                'webhook_secret' => 'whsec_mock_webhook',
            ],
            'health_status' => 'healthy',
        ]);
    }

    /** @test */
    public function payment_gateway_manager_can_resolve_registered_drivers()
    {
        $manager = app(PaymentGatewayManager::class);

        $codDriver = $manager->driver('cod');
        $stripeDriver = $manager->driver('stripe');

        $this->assertInstanceOf(CodDriver::class, $codDriver);
        $this->assertInstanceOf(StripeDriver::class, $stripeDriver);
    }

    /** @test */
    public function default_gateway_resolution_falls_back_to_is_default_flag()
    {
        $manager = app(PaymentGatewayManager::class);
        $this->assertEquals('cod', $manager->getDefaultGatewayCode());
    }

    /** @test */
    public function fallback_routing_successfully_switches_gateway_when_primary_fails()
    {
        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'grand_total' => 500.00,
            'payment_method' => 'stripe',
            'payment_status' => 'pending',
            'status' => 'new',
            'currency' => 'inr',
            'shipping_amount' => 0,
            'shipping_method' => 'standard',
        ]);

        $manager = app(PaymentGatewayManager::class);

        // Mark stripe as degraded/down
        PaymentGateway::where('code', 'stripe')->update(['health_status' => 'down']);

        // Execute fallback routing
        $response = $manager->fallbackRoute('stripe', $order);

        // Should fallback to COD
        $this->assertNotNull($response);
        $this->assertTrue($response->success);
        
        $order->refresh();
        $this->assertEquals('cod', $order->payment_method);
        $this->assertStringContainsString('Fallback routed', $order->notes);
    }

    /** @test */
    public function stripe_driver_generates_checkout_session_successfully()
    {
        Http::fake([
            'https://api.stripe.com/v1/checkout/sessions' => Http::response([
                'id' => 'cs_test_session_123',
                'url' => 'https://checkout.stripe.com/pay/cs_test_session_123',
            ], 200)
        ]);

        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'grand_total' => 1200.00,
            'payment_method' => 'stripe',
            'payment_status' => 'pending',
            'status' => 'new',
            'currency' => 'inr',
            'shipping_amount' => 0,
            'shipping_method' => 'standard',
        ]);

        $driver = app(PaymentGatewayManager::class)->driver('stripe');
        $response = $driver->purchase($order);

        $this->assertTrue($response->success);
        $this->assertEquals('cs_test_session_123', $response->transactionId);
        $this->assertEquals('https://checkout.stripe.com/pay/cs_test_session_123', $response->redirectUrl);
    }

    /** @test */
    public function webhook_endpoint_verifies_stripe_events()
    {
        Event::fake();

        $user = User::factory()->create();
        $order = Order::create([
            'user_id' => $user->id,
            'grand_total' => 1500.00,
            'payment_method' => 'stripe',
            'payment_status' => 'pending',
            'status' => 'new',
            'currency' => 'inr',
            'shipping_amount' => 0,
            'shipping_method' => 'standard',
        ]);

        // Construct valid Stripe signature for testing signature verification
        $timestamp = time();
        $payload = json_encode([
            'id' => 'evt_test_webhook',
            'type' => 'checkout.session.completed',
            'data' => [
                'object' => [
                    'id' => 'cs_test_session_123',
                    'amount_total' => 150000,
                    'metadata' => [
                        'order_id' => $order->id,
                    ]
                ]
            ]
        ]);

        $webhookSecret = 'whsec_mock_webhook';
        $signedPayload = $timestamp . '.' . $payload;
        $signature = hash_hmac('sha256', $signedPayload, $webhookSecret);
        $header = "t={$timestamp},v1={$signature}";

        $response = $this->withHeaders([
            'Stripe-Signature' => $header
        ])->postJson(route('payment.webhook', ['gateway' => 'stripe']), json_decode($payload, true));

        $response->assertStatus(200);

        // Verify order is marked paid and event was dispatched
        $order->refresh();
        $this->assertEquals('paid', $order->payment_status);
        $this->assertEquals('processing', $order->status);

        Event::assertDispatched(PaymentReceived::class);
    }
}
