<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductDetailPage extends Component
{
    use LivewireAlert;

    public $product;
    public $title;
    public $quantity = 1;

    // Review fields
    public $rating = 5;
    public $comment;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->with('approvedReviews.user')->firstOrFail();
        $this->title = $this->product->name . " - ByteWebster";
    }

    public function increaseQty()
    {
        $this->quantity++;
    }

    public function decreaseQty()
    {
        if ($this->quantity > 1)
        {
            $this->quantity--;
        }
    }

    // Method for adding the product in the cart

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id, $this->quantity);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to the cart successfully!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        
    }

    public function submitReview()
    {
        if (!auth()->check()) {
            $this->alert('error', 'Please login to leave a review.', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        $this->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $existing = \App\Models\Review::where('user_id', auth()->id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($existing) {
            $this->alert('warning', 'You have already reviewed this product.', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'product_id' => $this->product->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'is_approved' => true,
        ]);

        $this->comment = '';
        $this->rating = 5;

        // Reload the product relationships
        $this->product->load('approvedReviews.user');

        $this->alert('success', 'Thank you! Your review has been posted.', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }

    public function toggleWishlist()
    {
        if (!auth()->check()) {
            $this->alert('info', 'Please log in to add items to your wishlist.', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
            return;
        }

        $existing = \App\Models\Wishlist::where('user_id', auth()->id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $this->dispatch('update-wishlist-count');
            $this->alert('success', 'Removed from wishlist.', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            \App\Models\Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $this->product->id,
            ]);
            $this->dispatch('update-wishlist-count');
            $this->alert('success', 'Added to wishlist!', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
            ]);
        }

        $this->product->load('wishlists');
    }

    public function render()
    {
        return view('livewire.product-detail-page', ['product' => $this->product])
            ->layoutData(['title' => $this->title]);
    }
}
