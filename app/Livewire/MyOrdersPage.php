<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Orders - ByteWebster')]
class MyOrdersPage extends Component
{
    use WithPagination;

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    }

    public function render()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);

        return view('livewire.my-orders-page', [
            'orders' => $orders,
        ]);
    }
}
