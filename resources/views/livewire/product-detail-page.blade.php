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
                        <i class="bi bi-truck text-xl text-blue-600"></i>
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
                    
                    <!-- Ratings summary -->
                    <div class="flex items-center space-x-2 pt-1">
                        <div class="flex text-yellow-400">
                            @php
                                $avg = $product->average_rating;
                                $fullStars = floor($avg);
                                $hasHalf = ($avg - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($hasHalf ? 1 : 0);
                            @endphp
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="bi bi-star-fill text-xs"></i>
                            @endfor
                            @if ($hasHalf)
                                <i class="bi bi-star-half text-xs"></i>
                            @endif
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="bi bi-star text-xs"></i>
                            @endfor
                        </div>
                        <span class="text-xs text-gray-500 dark:text-slate-400 font-medium">
                            {{ $product->average_rating }} ({{ $product->approvedReviews->count() }} {{ Str::plural('review', $product->approvedReviews->count()) }})
                        </span>
                    </div>
                    
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

                        <div class="flex-1 pt-6 flex items-center gap-2">
                            @if($product->in_stock)
                                <button type="button" wire:click="addToCart({{ $product->id }})" class="flex-1 py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">Adding...</span>
                                </button>
                            @else
                                <button type="button" disabled class="flex-1 py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-gray-200 text-gray-500 cursor-not-allowed dark:bg-slate-800 dark:text-slate-500">
                                    Out of Stock
                                </button>
                            @endif

                            @php
                                $isWishlisted = auth()->check() ? $product->isWishlistedByUser(auth()->id()) : false;
                            @endphp
                            <button type="button" wire:click="toggleWishlist" class="p-3 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl hover:bg-gray-100 dark:hover:bg-slate-700/60 transition shadow-sm" title="Add to Wishlist">
                                @if($isWishlisted)
                                    <i class="bi bi-heart-fill text-red-500 text-lg"></i>
                                @else
                                    <i class="bi bi-heart text-gray-500 dark:text-slate-400 text-lg"></i>
                                @endif
                            </button>
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

    <!-- Reviews and Feedback Section -->
    <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 sm:p-10 shadow-sm mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Left: Ratings Stats -->
            <div class="space-y-6 text-left">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Customer Reviews</h3>
                
                <div class="flex items-center space-x-4">
                    <span class="text-5xl font-extrabold text-gray-800 dark:text-white">{{ $product->average_rating }}</span>
                    <div>
                        <div class="flex text-yellow-400">
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="bi bi-star-fill text-base"></i>
                            @endfor
                            @if ($hasHalf)
                                <i class="bi bi-star-half text-base"></i>
                            @endif
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="bi bi-star text-base"></i>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Based on {{ $product->approvedReviews->count() }} ratings</p>
                    </div>
                </div>

                <!-- Rating bars -->
                <div class="space-y-2">
                    @php
                        $totalReviews = max(1, $product->approvedReviews->count());
                    @endphp
                    @for ($star = 5; $star >= 1; $star--)
                        @php
                            $starCount = $product->approvedReviews->where('rating', $star)->count();
                            $percentage = round(($starCount / $totalReviews) * 100);
                        @endphp
                        <div class="flex items-center text-sm">
                            <span class="w-12 text-gray-600 dark:text-slate-400 font-medium">{{ $star }} Star</span>
                            <div class="flex-1 mx-3 bg-gray-100 dark:bg-slate-800 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="w-8 text-right text-gray-400 text-xs">{{ $percentage }}%</span>
                        </div>
                    @endfor
                </div>

                <!-- Write a Review Form -->
                <div class="pt-6 border-t border-gray-100 dark:border-slate-800/80">
                    <h4 class="font-bold text-gray-800 dark:text-white text-sm mb-4">Share your thoughts</h4>
                    @auth
                        <form wire:submit.prevent="submitReview" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Rating</label>
                                <select wire:model="rating" class="w-full py-2 px-3 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-xs focus:border-blue-500 focus:ring-blue-500 dark:text-white">
                                    <option value="5">★★★★★ (5 Stars)</option>
                                    <option value="4">★★★★☆ (4 Stars)</option>
                                    <option value="3">★★★☆☆ (3 Stars)</option>
                                    <option value="2">★★☆☆☆ (2 Stars)</option>
                                    <option value="1">★☆☆☆☆ (1 Star)</option>
                                </select>
                                @error('rating') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Comment</label>
                                <textarea wire:model="comment" rows="3" placeholder="Write your review here..." class="w-full py-2 px-3 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-xs focus:border-blue-500 focus:ring-blue-500 dark:text-white"></textarea>
                                @error('comment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full py-2.5 px-4 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 shadow-md shadow-blue-500/10 transition hover-lift">
                                Submit Review
                            </button>
                        </form>
                    @else
                        <div class="p-4 bg-gray-50 dark:bg-slate-800/40 border border-gray-200 dark:border-slate-700 rounded-2xl text-center">
                            <p class="text-xs text-gray-400">Please login to write a product review.</p>
                            <a href="{{ route('login') }}" class="inline-block mt-3 text-xs font-semibold text-blue-600 hover:text-blue-500">Log In &rarr;</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Right: Approved reviews list -->
            <div class="lg:col-span-2 space-y-6 text-left">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-slate-800/80 pb-3">
                    Reviews ({{ $product->approvedReviews->count() }})
                </h3>

                @if ($product->approvedReviews->isEmpty())
                    <div class="py-12 text-center text-gray-400">
                        <i class="bi bi-chat-left-dots text-4xl mb-3 block text-gray-300"></i>
                        <p class="text-sm">No reviews yet for this product. Be the first to leave one!</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-100 dark:divide-slate-800/60 max-h-[500px] overflow-y-auto pr-3 space-y-4">
                        @foreach ($product->approvedReviews as $rev)
                            <div class="pt-4 first:pt-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-xs">
                                            {{ strtoupper(substr($rev->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="block text-xs font-bold text-gray-800 dark:text-white">{{ $rev->user->name }}</span>
                                            <span class="block text-[10px] text-gray-400">{{ $rev->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400 text-xs">
                                        @for ($i = 0; $i < $rev->rating; $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                        @for ($i = 0; $i < (5 - $rev->rating); $i++)
                                            <i class="bi bi-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                @if ($rev->comment)
                                    <p class="mt-2 text-xs text-gray-600 dark:text-slate-300 leading-relaxed bg-gray-50 dark:bg-slate-800/30 p-3 rounded-xl border border-gray-100/50 dark:border-slate-800/40">
                                        {{ $rev->comment }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>