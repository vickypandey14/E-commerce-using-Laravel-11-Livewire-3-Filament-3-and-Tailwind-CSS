@php
    $firstImage = !empty($product->images) && isset($product->images[0]) ? $product->images[0] : null;
    $mainImage = $firstImage
        ? ((str_starts_with($firstImage, 'http://') || str_starts_with($firstImage, 'https://')) ? $firstImage : url('storage/' . $firstImage))
        : 'https://placehold.co/600x600/6366f1/ffffff?text=' . urlencode($product->name);
@endphp

<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto" x-data="{ mainImage: '{{ $mainImage }}' }">
    <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 sm:p-10 shadow-sm">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Left: Product Images -->
            <div class="w-full lg:w-1/2 space-y-6">
                <!-- Large Main Image View -->
                <div class="relative bg-slate-50 dark:bg-slate-950/20 border border-gray-100 dark:border-slate-800/80 rounded-2xl aspect-square overflow-hidden flex items-center justify-center shadow-sm">
                    <img x-bind:src="mainImage" alt="{{ $product->name }}" class="object-contain w-full h-full p-6 transition duration-300">
                    
                    @if($product->on_sale)
                        <span class="absolute top-4 left-4 bg-red-500 text-white font-bold text-xs uppercase tracking-wider px-3 py-1 rounded-full shadow">Sale</span>
                    @endif
                </div>

                <!-- Thumbnail Carousel/Grid -->
                @if(!empty($product->images) && count($product->images) > 1)
                    <div class="flex flex-wrap gap-3">
                        @foreach ($product->images as $image)
                            @php
                                $thumbUrl = (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) ? $image : url('storage/' . $image);
                            @endphp
                            <button x-on:click="mainImage = '{{ $thumbUrl }}'" class="w-20 h-20 bg-slate-50 dark:bg-slate-950/20 border hover:border-blue-600 dark:border-slate-800 rounded-xl overflow-hidden p-1 transition">
                                <img src="{{ $thumbUrl }}" alt="{{ $product->name }}" class="object-contain w-full h-full">
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Shipping Feature List -->
                <div class="pt-6 border-t border-gray-100 dark:border-slate-800/85">
                    <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-slate-400">
                        <span class="text-xl">🚚</span>
                        <div>
                            <span class="font-bold text-gray-800 dark:text-white">Free Express Shipping</span>
                            <p class="text-xs text-gray-400 mt-0.5">Estimated delivery: 3 - 5 business days.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Product Information -->
            <div class="w-full lg:w-1/2 space-y-6 text-left">
                <div class="space-y-2">
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-bold uppercase tracking-widest">{{ $product->brand->name ?? 'Brand' }}</span>
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-gray-800 dark:text-white leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <!-- Stock Badge -->
                    <div class="pt-2">
                        @if($product->in_stock)
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-600 dark:bg-green-400"></span>
                                In Stock
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600 dark:bg-red-400"></span>
                                Out of Stock
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Price and Info -->
                <div class="py-4 border-y border-gray-100 dark:border-slate-800/80">
                    <p class="text-3xl font-extrabold text-blue-600 dark:text-blue-400">
                        {{ Number::currency($product->price, 'INR') }}
                    </p>
                    @if($product->sku)
                        <p class="text-xs text-gray-400 dark:text-slate-500 mt-2 font-mono">SKU: {{ $product->sku }}</p>
                    @endif
                </div>

                <!-- Short Description -->
                <div class="text-gray-600 dark:text-slate-300 text-sm leading-relaxed prose dark:prose-invert">
                    @if($product->short_description)
                        {!! Str::markdown($product->short_description) !!}
                    @else
                        <p>No description provided for this product.</p>
                    @endif
                </div>

                <!-- Actions -->
                <div class="space-y-4 pt-4">
                    <div class="flex items-center gap-4">
                        <div class="w-32">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Quantity</label>
                            <div class="flex items-center bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl overflow-hidden">
                                <button type="button" wire:click="decreaseQty" class="p-2.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-slate-700/50 transition w-10 flex items-center justify-center font-bold">
                                    -
                                </button>
                                <span class="flex-1 text-center font-bold text-sm text-gray-800 dark:text-white">
                                    {{ $quantity }}
                                </span>
                                <button type="button" wire:click="increaseQty" class="p-2.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-slate-700/50 transition w-10 flex items-center justify-center font-bold">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="flex-1 pt-6">
                            @if($product->in_stock)
                                <button type="button" wire:click="addToCart({{ $product->id }})" class="w-full py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">Adding...</span>
                                </button>
                            @else
                                <button type="button" disabled class="w-full py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-gray-200 text-gray-500 cursor-not-allowed dark:bg-slate-800 dark:text-slate-500">
                                    Out of Stock
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Full Description / Additional Info Accordion -->
                @if($product->description)
                    <div class="pt-6 border-t border-gray-100 dark:border-slate-800/80">
                        <h3 class="font-bold text-gray-800 dark:text-white text-base mb-3">Product Specifications</h3>
                        <div class="text-gray-500 dark:text-slate-400 text-sm leading-relaxed prose dark:prose-invert">
                            {!! Str::markdown($product->description) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>