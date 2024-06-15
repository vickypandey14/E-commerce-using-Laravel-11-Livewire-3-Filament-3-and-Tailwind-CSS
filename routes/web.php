<?php

use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;


Route::get('/', HomePage::class);

// Route::get('/', function () {
//     return view('welcome');
// });
