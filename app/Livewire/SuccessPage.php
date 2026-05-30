<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Url;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Success - ByteWebster')]
class SuccessPage extends Component
{
    #[Url]
    public $order_id;

    public $order;

    public function mount()
    {
        if ($this->order_id) {
            $this->order = Order::with('address', 'items.product')->find($this->order_id);
        }
        
        if (!$this->order || $this->order->user_id !== auth()->id()) {
            return redirect()->route('index');
        }
    }

    public function render()
    {
        return view('livewire.success-page');
    }
}
