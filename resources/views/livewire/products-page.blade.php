<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Filter Sidebar -->
        <div class="w-full lg:w-1/4 space-y-6">
            <!-- Search bar inside products page for instant filtering -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 text-sm uppercase tracking-wider mb-3">Search</h3>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name..." class="py-2.5 pl-10 pr-4 block w-full bg-gray-50 border border-gray-200/80 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-gray-400">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-3.5">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Categories Filter -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 text-sm uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-slate-800/80 pb-2">Categories</h3>
                <div class="space-y-3 max-h-48 overflow-y-auto pr-2">
                    @foreach ($categories as $category)
                        <label for="cat-{{ $category->id }}" class="flex items-center text-sm text-gray-600 dark:text-slate-300 cursor-pointer select-none">
                            <input type="checkbox" wire:model.live="selected_categories" id="cat-{{ $category->id }}" value="{{ $category->id }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mr-3">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Brands Filter -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 text-sm uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-slate-800/80 pb-2">Brands</h3>
                <div class="space-y-3 max-h-48 overflow-y-auto pr-2">
                    @foreach ($brands as $brand)
                        <label for="brand-{{ $brand->id }}" class="flex items-center text-sm text-gray-600 dark:text-slate-300 cursor-pointer select-none">
                            <input type="checkbox" wire:model.live="selected_brands" id="brand-{{ $brand->id }}" value="{{ $brand->id }}" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mr-3">
                            <span>{{ $brand->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Status Filter -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 text-sm uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-slate-800/80 pb-2">Status</h3>
                <div class="space-y-3">
                    <label for="filter-featured" class="flex items-center text-sm text-gray-600 dark:text-slate-300 cursor-pointer select-none">
                        <input type="checkbox" id="filter-featured" wire:model.live="featured" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mr-3">
                        <span>Featured Products</span>
                    </label>
                    <label for="filter-onsale" class="flex items-center text-sm text-gray-600 dark:text-slate-300 cursor-pointer select-none">
                        <input type="checkbox" id="filter-onsale" wire:model.live="on_sale" value="1" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mr-3">
                        <span>On Sale</span>
                    </label>
                </div>
            </div>

            <!-- Price Filter -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
                <h3 class="font-bold text-gray-800 dark:text-gray-200 text-sm uppercase tracking-wider mb-4 border-b border-gray-100 dark:border-slate-800/80 pb-2">Price Limit</h3>
                <div class="space-y-4">
                    <div class="flex justify-between text-xs font-bold text-blue-600 dark:text-blue-400">
                        <span>Max Range:</span>
                        <span>{{ Number::currency($price_range, 'INR') }}</span>
                    </div>
                    <input type="range" wire:model.live="price_range" min="0" max="500000" step="5000" class="w-full h-1.5 bg-blue-100 dark:bg-slate-800 rounded-lg appearance-none cursor-pointer">
                    <div class="flex justify-between text-xs text-gray-400">
                        <span>₹0</span>
                        <span>₹5,00,000</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Listing -->
        <div class="w-full lg:w-3/4 space-y-6">
            <!-- Header bar with sorting options -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-4 shadow-sm flex flex-wrap items-center justify-between gap-4">
                <p class="text-sm font-medium text-gray-500 dark:text-slate-400">
                    Showing <span class="text-gray-800 dark:text-white font-bold">{{ $products->count() }}</span> products
                </p>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Sort by:</span>
                    <select wire:model.live="sort" class="py-1.5 px-3 block bg-gray-50 border border-gray-200 rounded-lg text-xs focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-gray-400 cursor-pointer">
                        <option value="latest">Latest Arrivals</option>
                        <option value="price">Price (Low to High)</option>
                    </select>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->isEmpty())
                <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-16 text-center shadow-sm">
                    <span class="text-5xl">🔍</span>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-200 mt-4">No Products Found</h3>
                    <p class="text-gray-500 dark:text-slate-400 text-sm mt-1">Try updating your filters or search criteria.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @foreach ($products as $product)
                        <div class="group flex flex-col bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift overflow-hidden" wire:key="product-card-{{ $product->id }}">
                            <!-- Image Display -->
                            <div class="relative bg-slate-50 dark:bg-slate-950/20 aspect-video sm:aspect-square overflow-hidden flex items-center justify-center">
                                <a wire:navigate href="{{ route('product-details', $product->slug) }}" class="w-full h-full flex items-center justify-center">
                                    <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="object-contain w-full h-full p-4 transform group-hover:scale-105 transition duration-300">
                                </a>

                                <!-- On Sale Badge -->
                                @if($product->on_sale)
                                    <span class="absolute top-3 left-3 bg-red-500 text-white font-bold text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full shadow">Sale</span>
                                @endif
                                <!-- Featured Badge -->
                                @if($product->is_featured)
                                    <span class="absolute top-3 right-3 bg-blue-600 text-white font-bold text-[10px] uppercase tracking-wider px-2 py-0.5 rounded-full shadow">Featured</span>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div class="space-y-1">
                                    <p class="text-[10px] text-blue-600 dark:text-blue-400 font-bold uppercase tracking-widest">{{ $product->brand->name ?? 'Brand' }}</p>
                                    <a wire:navigate href="{{ route('product-details', $product->slug) }}" class="block font-bold text-gray-800 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition text-sm sm:text-base leading-snug">
                                        {{ $product->name }}
                                    </a>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-800/80 flex items-center justify-between">
                                    <p class="text-base sm:text-lg font-extrabold text-blue-600 dark:text-blue-400">
                                        {{ Number::currency($product->price, 'INR') }}
                                    </p>
                                    
                                    <button wire:click.prevent="addToCart({{ $product->id }})" class="p-2 bg-blue-50 hover:bg-blue-600 dark:bg-slate-800 dark:hover:bg-blue-600 text-blue-600 dark:text-blue-400 hover:text-white dark:hover:text-white rounded-xl transition shadow-sm flex items-center gap-1 text-xs font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
                                        </svg>
                                        <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add</span>
                                        <span wire:loading wire:target="addToCart({{ $product->id }})">...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8 flex justify-end">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>