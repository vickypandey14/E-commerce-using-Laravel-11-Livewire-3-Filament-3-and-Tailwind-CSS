<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto text-left">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-xs text-gray-500 dark:text-slate-400 font-medium" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center hover:text-blue-600 dark:hover:text-blue-500">
                    <i class="bi bi-house-door-fill mr-1.5 text-sm"></i>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="bi bi-chevron-right mx-1 text-gray-400 dark:text-slate-650 text-[10px]"></i>
                    <span class="text-gray-800 dark:text-white font-semibold">Wishlist</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-2xl mx-auto mb-10">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 dark:text-white sm:text-4xl">My Wishlist</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">Manage your favorite items and transfer them to your cart.</p>
    </div>

    @if($wishlist_items->isEmpty())
        <div class="max-w-md mx-auto text-center py-16 bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-8 shadow-sm">
            <div class="w-16 h-16 bg-red-50 dark:bg-red-950/20 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"></path>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Your wishlist is empty</h2>
            <p class="text-xs text-gray-400 mt-2">Explore our electronics catalog to bookmark your favorite items.</p>
            <a wire:navigate href="/products" class="inline-flex justify-center items-center gap-x-2 text-xs font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 px-4 py-2.5 mt-6 transition">
                Explore Products
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlist_items as $item)
                @if($item->product)
                    @php
                        $firstImage = !empty($item->product->images) && isset($item->product->images[0]) ? $item->product->images[0] : null;
                        $imageUrl = $firstImage
                            ? ((str_starts_with($firstImage, 'http://') || str_starts_with($firstImage, 'https://')) ? $firstImage : url('storage/' . $firstImage))
                            : 'https://placehold.co/600x600/6366f1/ffffff?text=' . urlencode($item->product->name);
                    @endphp
                    
                    <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group relative">
                        <!-- Remove button -->
                        <button type="button" wire:click="removeItem({{ $item->id }})" class="absolute top-4 right-4 z-10 w-8 h-8 rounded-full bg-white dark:bg-slate-800 text-red-500 border border-gray-100 dark:border-slate-700 shadow-sm flex items-center justify-center hover:bg-red-50 dark:hover:bg-red-950/30 transition" title="Remove from wishlist">
                            <i class="bi bi-heart-fill text-sm"></i>
                        </button>

                        <!-- Product Image Link -->
                        <a wire:navigate href="/product/{{ $item->product->slug }}" class="block aspect-square overflow-hidden bg-slate-50 dark:bg-slate-950/20 p-6 flex items-center justify-center relative">
                            <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}" class="object-contain w-full h-full transform group-hover:scale-105 transition duration-300">
                        </a>

                        <!-- Product details -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div class="space-y-1.5 text-left">
                                <span class="text-[10px] text-blue-600 dark:text-blue-400 font-bold uppercase tracking-wider">{{ $item->product->brand->name ?? 'Brand' }}</span>
                                <a wire:navigate href="/product/{{ $item->product->slug }}" class="block font-bold text-gray-800 dark:text-white text-xs hover:text-blue-600 dark:hover:text-blue-400 transition line-clamp-2">
                                    {{ $item->product->name }}
                                </a>
                            </div>

                            <div class="pt-4 mt-auto space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-extrabold text-blue-600 dark:text-blue-400">
                                        {{ Number::currency($item->product->price, 'INR') }}
                                    </span>
                                    
                                    @if($item->product->in_stock)
                                        <span class="text-[10px] font-bold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-950/20 px-2 py-0.5 rounded-full">In Stock</span>
                                    @else
                                        <span class="text-[10px] font-bold text-red-500 bg-red-50 dark:bg-red-950/20 px-2 py-0.5 rounded-full">Out of Stock</span>
                                    @endif
                                </div>

                                <button type="button" 
                                        wire:click="addToCart({{ $item->product->id }})" 
                                        @if(!$item->product->in_stock) disabled @endif
                                        class="w-full py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-xs font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition disabled:bg-gray-150 disabled:text-gray-400 disabled:cursor-not-allowed dark:disabled:bg-slate-800 dark:disabled:text-slate-500">
                                    <i class="bi bi-cart text-sm"></i>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
