<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Categories - ByteWebster')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.categories-page', compact('categories'));
    }
}
