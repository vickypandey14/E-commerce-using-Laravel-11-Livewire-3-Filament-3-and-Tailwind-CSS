<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Order Details - ByteWebster')]
class MyOrderDetailPage extends Component
{
    public $order;

    public function mount($order)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $this->order = Order::with('address', 'items.product')->where('user_id', auth()->id())->where('id', $order)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.my-order-detail-page');
    }
}
