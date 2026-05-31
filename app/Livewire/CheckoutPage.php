<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Checkout - ByteWebster')]
class CheckoutPage extends Component
{
    public $cart_items = [];
    public $grand_total = 0;

    // Address fields
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method = 'cod'; // default
    public $active_gateways = [];

    // Coupon fields
    public $coupon_code;
    public $discount_amount = 0;
    public $applied_coupon;

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->cart_items = CartManagement::getCartItemsFromCookie();
        if (count($this->cart_items) == 0) {
            return redirect()->route('all-products');
        }

        $this->grand_total = CartManagement::calculateGrandTotal($this->cart_items);

        // Prepopulate with user details if possible
        $user = auth()->user();
        $nameParts = explode(' ', $user->name, 2);
        $this->first_name = $nameParts[0] ?? '';
        $this->last_name = $nameParts[1] ?? '';

        // Load active payment gateways
        $manager = app(\App\Services\Payment\PaymentGatewayManager::class);
        $this->active_gateways = $manager->getActiveGateways()->toArray();
        $this->payment_method = $manager->getDefaultGatewayCode();
    }

    public function applyCoupon()
    {
        if (empty($this->coupon_code)) {
            session()->flash('coupon_error', 'Please enter a promo code.');
            return;
        }

        $coupon = \App\Models\Coupon::where('code', strtoupper($this->coupon_code))->first();

        if (!$coupon) {
            session()->flash('coupon_error', 'Invalid promo code.');
            $this->discount_amount = 0;
            $this->applied_coupon = null;
            $this->recalculateTotal();
            return;
        }

        if (!$coupon->isValid()) {
            session()->flash('coupon_error', 'This promo code is inactive or expired.');
            $this->discount_amount = 0;
            $this->applied_coupon = null;
            $this->recalculateTotal();
            return;
        }

        $subtotal = CartManagement::calculateGrandTotal($this->cart_items);

        if (!$coupon->isValidForAmount($subtotal)) {
            session()->flash('coupon_error', 'Minimum order value of ' . \Illuminate\Support\Number::currency($coupon->min_amount, 'INR') . ' required.');
            $this->discount_amount = 0;
            $this->applied_coupon = null;
            $this->recalculateTotal();
            return;
        }

        $this->discount_amount = $coupon->calculateDiscount($subtotal);
        $this->applied_coupon = $coupon->code;
        $this->recalculateTotal();

        session()->flash('coupon_success', 'Promo code applied successfully!');
    }

    public function recalculateTotal()
    {
        $subtotal = CartManagement::calculateGrandTotal($this->cart_items);
        $this->grand_total = max(0, $subtotal - $this->discount_amount);
    }

    public function placeOrder()
    {
        $activeCodes = collect($this->active_gateways)->pluck('code')->implode(',');

        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'payment_method' => 'required|string|in:' . ($activeCodes ?: 'cod'),
        ]);

        // Create the order
        $order = \Illuminate\Support\Facades\DB::transaction(function () {
            $order = Order::create([
                'user_id' => auth()->id(),
                'grand_total' => $this->grand_total,
                'payment_method' => $this->payment_method,
                'payment_status' => 'pending', // all start pending, completed by driver callback/webhook
                'status' => 'new',
                'currency' => 'inr',
                'shipping_amount' => 0.00,
                'shipping_method' => 'standard',
                'notes' => 'Placed via checkout page.',
                'coupon_code' => $this->applied_coupon,
                'discount_amount' => $this->discount_amount,
            ]);

            // Create order items
            foreach ($this->cart_items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_amount' => $item['unit_amount'],
                    'total_amount' => $item['total_amount'],
                ]);

                // Log stock reduction in inventory logs
                \App\Models\InventoryLog::create([
                    'product_id' => $item['product_id'],
                    'user_id' => auth()->id(),
                    'quantity_change' => -$item['quantity'],
                    'reason' => 'Customer Purchase (Order #' . $order->id . ')',
                ]);
            }

            // Create address
            Address::create([
                'order_id' => $order->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'phone' => $this->phone,
                'street_address' => $this->street_address,
                'city' => $this->city,
                'state' => $this->state,
                'zip_code' => $this->zip_code,
            ]);

            return $order;
        });

        // Initialize payment via Gateway Manager
        $manager = app(\App\Services\Payment\PaymentGatewayManager::class);

        try {
            $driver = $manager->driver($this->payment_method);

            // Log pending transaction
            $transaction = \App\Models\PaymentTransaction::create([
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'gateway_code' => $this->payment_method,
                'amount' => $order->grand_total,
                'currency' => $order->currency ?? 'INR',
                'status' => 'pending',
                'type' => 'payment',
            ]);

            $response = $driver->purchase($order);

            if ($response->success) {
                // Clear the cart
                CartManagement::clearCartItems();
                $this->dispatch('update-cart-count', total_count: 0)->to(\App\Livewire\Partials\Navbar::class);

                // Update transaction ID with the one returned by gateway
                if ($response->transactionId) {
                    $transaction->update(['gateway_transaction_id' => $response->transactionId]);
                }

                // Handle redirect or final success routing
                if ($response->redirectUrl) {
                    return redirect($response->redirectUrl);
                }

                // If COD or processes instantly
                if ($this->payment_method === 'cod') {
                    $order->update([
                        'payment_status' => 'pending',
                    ]);
                    event(new \App\Events\PaymentReceived($order));
                }

                return redirect()->route('success', ['order_id' => $order->id]);
            }

            // Primary gateway purchase failed. Log error and trigger automated fallback routing.
            $transaction->update([
                'status' => 'failed',
                'error_message' => $response->errorMessage ?? 'Payment failed',
            ]);

            $fallbackResponse = $manager->fallbackRoute($this->payment_method, $order);
            if ($fallbackResponse && $fallbackResponse->success) {
                CartManagement::clearCartItems();
                $this->dispatch('update-cart-count', total_count: 0)->to(\App\Livewire\Partials\Navbar::class);

                session()->flash('warning', 'Primary payment gateway failed. Auto-routed to fallback gateway.');

                if ($fallbackResponse->redirectUrl) {
                    return redirect($fallbackResponse->redirectUrl);
                }
                return redirect()->route('success', ['order_id' => $order->id]);
            }

            session()->flash('coupon_error', $response->errorMessage ?? 'Payment processing failed. Please try again.');
            return;

        } catch (\Exception $e) {
            Log::error("Checkout Order placement exception: " . $e->getMessage());

            // Attempt fallback on exception
            $fallbackResponse = $manager->fallbackRoute($this->payment_method, $order);
            if ($fallbackResponse && $fallbackResponse->success) {
                CartManagement::clearCartItems();
                $this->dispatch('update-cart-count', total_count: 0)->to(\App\Livewire\Partials\Navbar::class);
                session()->flash('warning', 'Gateway connection error. Auto-routed to fallback.');
                if ($fallbackResponse->redirectUrl) {
                    return redirect($fallbackResponse->redirectUrl);
                }
                return redirect()->route('success', ['order_id' => $order->id]);
            }

            session()->flash('coupon_error', 'An error occurred during payment setup: ' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
