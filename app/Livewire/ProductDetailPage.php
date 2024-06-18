<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductDetailPage extends Component
{
    public $product;
    public $title;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->firstOrFail();
        $this->title = $this->product->name . " - ByteWebster";
    }

    public function render()
    {
        return view('livewire.product-detail-page', ['product' => $this->product])
            ->layoutData(['title' => $this->title]);
    }
}
