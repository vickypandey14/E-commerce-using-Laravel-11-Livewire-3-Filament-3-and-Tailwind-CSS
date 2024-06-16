<?php

use App\Livewire\CartPage;
use App\Livewire\CategoriesPage;
use App\Livewire\CheckoutPage;
use App\Livewire\HomePage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductDetailPage;
use App\Livewire\ProductsPage;
use Illuminate\Support\Facades\Route;


Route::get('/', HomePage::class)->name('index');

Route::get('/categories', CategoriesPage::class)->name('product-categories');

Route::get('/products', ProductsPage::class)->name('all-products');

Route::get('/product/{product}', ProductDetailPage::class)->name('product-details');

Route::get('/cart', CartPage::class)->name('cart-products');

Route::get('/checkout', CheckoutPage::class)->name('checkout');

Route::get('/my-orders', MyOrdersPage::class)->name('my-orders');

// Route::get('/', function () {
//     return view('welcome');
// });
