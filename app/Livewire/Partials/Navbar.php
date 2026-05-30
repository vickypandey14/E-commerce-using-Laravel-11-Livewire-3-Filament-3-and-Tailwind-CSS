<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public $total_count = 0;
    public $wishlist_count = 0;

    public function mount()
    {
        $this->total_count = count(CartManagement::getCartItemsFromCookie());
        $this->wishlist_count = auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0;
    }

    #[On('update-cart-count')]
    public function updateCartCount($total_count)
    {
        $this->total_count = $total_count;
    }

    #[On('update-wishlist-count')]
    public function updateWishlistCount()
    {
        $this->wishlist_count = auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0;
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
