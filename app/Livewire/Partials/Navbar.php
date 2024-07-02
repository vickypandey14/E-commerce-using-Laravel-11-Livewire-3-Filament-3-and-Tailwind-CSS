<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use Livewire\Component;

class Navbar extends Component
{
    public $total_count = 0;

    public function mount()
    {
        $this->total_count = count(CartManagement::getCartItemsFromCookie());
    }

    public function updateCartCount()
    {
        
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
