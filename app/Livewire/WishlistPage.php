<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Wishlist;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Wishlist - ByteWebster')]
class WishlistPage extends Component
{
    use LivewireAlert;

    public function mount()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
    }

    public function removeItem($wishlistId)
    {
        $wishlist = Wishlist::where('id', $wishlistId)->where('user_id', auth()->id())->first();
        if ($wishlist) {
            $wishlist->delete();
            $this->dispatch('update-wishlist-count');
            $this->alert('success', 'Item removed from wishlist.', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function addToCart($productId)
    {
        // Add to cart
        $total_count = CartManagement::addItemToCart($productId, 1);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        // Remove from wishlist
        Wishlist::where('user_id', auth()->id())->where('product_id', $productId)->delete();
        $this->dispatch('update-wishlist-count');

        $this->alert('success', 'Added to cart and removed from wishlist!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function render()
    {
        $wishlist_items = Wishlist::where('user_id', auth()->id())
            ->with('product')
            ->latest()
            ->get();

        return view('livewire.wishlist-page', compact('wishlist_items'));
    }
}
