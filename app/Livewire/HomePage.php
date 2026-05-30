<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home - ByteWebster')]

class HomePage extends Component
{
    use LivewireAlert;

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
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();
        $featured_products = Product::where('is_active', 1)->where('is_featured', 1)->take(8)->get();
        $flash_deals = Product::where('is_active', 1)->where('on_sale', 1)->take(6)->get();

        // Fetch dynamic products for the carousel hero slider
        $hero_products = [
            'apple' => Product::where('brand_id', 1)->where('is_active', 1)->orderBy('is_featured', 'desc')->first(),
            'samsung' => Product::where('brand_id', 2)->where('is_active', 1)->orderBy('is_featured', 'desc')->first(),
            'sony' => Product::where('brand_id', 3)->where('is_active', 1)->orderBy('is_featured', 'desc')->first(),
        ];

        return view('livewire.home-page', compact('brands', 'categories', 'featured_products', 'flash_deals', 'hero_products'));
    }
}
