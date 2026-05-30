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
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        // Create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'grand_total' => $this->grand_total,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_method === 'cod' ? 'pending' : 'paid',
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

        // Clear the cart
        CartManagement::clearCartItems();
        $this->dispatch('update-cart-count', total_count: 0)->to(\App\Livewire\Partials\Navbar::class);

        // Redirect to success page
        return redirect()->route('success', ['order_id' => $order->id]);
    }

    public function render()
    {
        return view('livewire.checkout-page');
    }
}
