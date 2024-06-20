<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - ByteWebster')]
class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $featured = [];

    #[Url]
    public $on_sale = [];

    public function render()
    {
        $products = Product::query()->where('is_active', 1);

        $brands = Brand::where('is_active', 1)->get(['id', 'name', 'slug']);
        
        $categories = Category::where('is_active', 1)->get(['id', 'name', 'slug']);


        if(!empty($this->selected_categories))
        {
            $products->whereIn('category_id', $this->selected_categories);
        }

        if(!empty($this->selected_brands))
        {
            $products->whereIn('brand_id', $this->selected_brands);
        }

        if($this->featured){
            $products->where('is_featured', 1);
        }

        if($this->on_sale){
            $products->where('on_sale', 1);
        }

        return view('livewire.products-page', [
            'products' => $products->paginate(12),
            'brands' => $brands,
            'categories' => $categories
        ]);
    }
}
