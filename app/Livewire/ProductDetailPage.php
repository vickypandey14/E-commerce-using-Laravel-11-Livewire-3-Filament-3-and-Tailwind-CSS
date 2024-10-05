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

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->firstOrFail();
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
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product added to the cart successfully!', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        
    }

    public function render()
    {
        return view('livewire.product-detail-page', ['product' => $this->product])
            ->layoutData(['title' => $this->title]);
    }
}
