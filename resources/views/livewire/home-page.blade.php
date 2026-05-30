<div class="w-full bg-slate-50/50 dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen">
    <!-- HERO SECTION -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/40 py-24 lg:py-32 border-b border-slate-200/60">
        <!-- Abstract gradient mesh & particles background -->
        <div class="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:20px_20px] opacity-40"></div>
        <div class="absolute top-0 right-1/4 w-[600px] h-[600px] bg-blue-450/10 rounded-full blur-3xl -z-10 animate-pulse"></div>
        <div class="absolute bottom-0 left-10 w-[600px] h-[600px] bg-indigo-450/10 rounded-full blur-3xl -z-10"></div>
        
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-12 gap-12 items-center">
                <!-- Left text column -->
                <div class="space-y-8 text-left lg:col-span-6">
                    <!-- Status Badge -->
                    <div class="inline-flex items-center gap-2 py-1.5 px-3.5 rounded-full text-xs font-semibold bg-blue-50 border border-blue-100 shadow-sm text-blue-600 backdrop-blur-md">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        Technology Without Compromise
                    </div>

                    <!-- Direct Headline -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.05]">
                        Sleek, Genuine Tech.<br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-650 to-cyan-600">Direct From Brands.</span>
                    </h1>

                    <!-- Clear Subheadline -->
                    <p class="text-lg text-slate-650 max-w-xl leading-relaxed">
                        Skip the markup and buy directly from manufacturer stocks. We inventory only authenticated smartphones, laptops, audio gear, and cameras with official worldwide warranties.
                    </p>
                    
                    <!-- Call to Action Buttons (Fixed Contrast & Styles) -->
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a wire:navigate href="/products" class="py-3.5 px-8 inline-flex justify-center items-center gap-x-2.5 text-sm font-bold rounded-xl bg-gradient-to-r from-blue-650 to-indigo-600 hover:from-blue-600 hover:to-indigo-500 text-white shadow-xl shadow-blue-500/10 hover:shadow-blue-500/20 hover:-translate-y-0.5 transition duration-200">
                            Shop Now
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                            </svg>
                        </a>
                        <a wire:navigate href="/categories" class="py-3.5 px-8 inline-flex justify-center items-center gap-x-2.5 text-sm font-bold rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 shadow-sm hover:-translate-y-0.5 transition duration-200">
                            Explore Categories
                        </a>
                    </div>

                    <!-- Enterprise Trust Badges -->
                    <div class="grid grid-cols-3 gap-6 pt-8 border-t border-slate-200/80 max-w-md">
                        <div>
                            <p class="text-3xl font-extrabold text-blue-600 tracking-tight">100%</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-1">Authorized Dealer</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold text-indigo-650 tracking-tight">24/7</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-1">Direct Support</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold text-cyan-600 tracking-tight">Free</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-1">Express Shipping</p>
                        </div>
                    </div>
                </div>

                <!-- Right visual column: Dynamic 3D floating layers -->
                <div class="lg:col-span-6 relative flex justify-center items-center h-[480px] lg:pl-10">
                    <!-- Subtle Glow Ring behind Image -->
                    <div class="absolute w-[450px] h-[450px] bg-blue-500/5 rounded-full blur-3xl -z-10"></div>
                    
                    <!-- Background Card (MacBook Pro - White Glassmorphic) -->
                    <div class="absolute w-[360px] aspect-[4/3] rounded-3xl bg-white/80 backdrop-blur-xl border border-slate-200/50 p-2.5 shadow-2xl transform -rotate-6 -translate-y-6 hover:rotate-0 hover:translate-y-0 transition-all duration-500 z-10 group">
                        <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=500&q=80" alt="MacBook Pro" class="w-full h-full object-cover rounded-2.5xl transition duration-300">
                    </div>

                    <!-- Mid Card (Sony Alpha Camera - White Glassmorphic) -->
                    <div class="absolute w-[220px] aspect-square rounded-3xl bg-white/95 backdrop-blur-xl border border-slate-200/60 p-2 shadow-2xl transform translate-x-24 translate-y-12 rotate-12 hover:rotate-0 hover:-translate-y-2 transition-all duration-500 z-20 hover:scale-105 group">
                        <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=400&q=80" alt="Sony Alpha Camera" class="w-full h-full object-cover rounded-2.5xl transition duration-300">
                        <span class="absolute bottom-3 left-3 px-2 py-0.5 bg-slate-900/90 backdrop-blur-sm rounded-lg text-[9px] font-bold text-white uppercase">Sony Alpha</span>
                    </div>

                    <!-- Foreground Card (Apple iPhone 15 Pro) -->
                    <div class="absolute w-[180px] aspect-[3/4] rounded-3xl bg-white border border-slate-200/80 p-2 shadow-2xl transform -translate-x-28 translate-y-16 -rotate-12 hover:rotate-0 transition-all duration-500 z-30 group hover:scale-105">
                        <img src="https://images.unsplash.com/photo-1695048133142-1a20484d2569?auto=format&fit=crop&w=400&q=80" alt="iPhone 15 Pro" class="w-full h-full object-cover rounded-2.5xl transition duration-300">
                        <!-- Glass overlay badge -->
                        <div class="absolute -top-3 -right-3 bg-blue-600 text-white font-bold text-[9px] uppercase px-2 py-1 rounded-lg shadow-lg">Trending</div>
                    </div>

                    <!-- Floating Pill Indicator 1: Rating -->
                    <div class="absolute top-8 right-2 lg:right-6 bg-white/95 backdrop-blur-md border border-slate-200 px-3.5 py-2 rounded-xl shadow-xl z-40 animate-bounce flex items-center gap-1.5 text-xs text-slate-805">
                        <span class="text-amber-500">★</span>
                        <span class="font-bold text-slate-800">4.9</span>
                        <span class="text-slate-500 text-[10px]">(3.2k Ratings)</span>
                    </div>

                    <!-- Floating Pill Indicator 2: Warranty -->
                    <div class="absolute bottom-8 left-2 lg:left-8 bg-white/95 backdrop-blur-md border border-slate-200/80 px-3.5 py-2 rounded-xl shadow-xl z-40 flex items-center gap-2 text-xs text-slate-800">
                        <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-ping"></div>
                        <span class="font-bold text-slate-800">Original Brand Warranty</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FLASH DEALS SECTION -->
    <div class="py-20 border-b border-slate-200/40 dark:border-slate-800/40 bg-white dark:bg-slate-900/40">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-12">
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg bg-red-500/10 text-red-650 dark:text-red-400 font-bold text-xs">
                        ⚡ Limited Offers
                    </span>
                    <h2 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                        Flash Deals of the Week
                    </h2>
                </div>

                <!-- Timer countdown -->
                <div class="flex items-center gap-2 bg-slate-100 dark:bg-slate-850 p-2.5 rounded-xl border border-slate-200/60 dark:border-slate-800/60">
                    <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest pl-1 mr-2">Ends In</span>
                    <div class="flex items-center gap-1.5">
                        <div class="w-8 h-8 rounded-lg bg-red-650 text-white flex flex-col items-center justify-center font-bold text-xs">
                            04
                        </div>
                        <span class="font-bold text-slate-400 dark:text-slate-500">:</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-900 dark:bg-slate-800 text-white flex flex-col items-center justify-center font-bold text-xs">
                            32
                        </div>
                        <span class="font-bold text-slate-400 dark:text-slate-500">:</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-900 dark:bg-slate-800 text-white flex flex-col items-center justify-center font-bold text-xs animate-pulse">
                            15
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horizontal Carousel scroll layout -->
            <div class="flex gap-6 overflow-x-auto pb-6 scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-800 snap-x">
                @foreach ($flash_deals as $product)
                    <div class="w-[280px] shrink-0 bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/60 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 snap-start flex flex-col justify-between" wire:key="deal-{{ $product->id }}">
                        <!-- Image & Badge Container -->
                        <div class="relative aspect-square bg-slate-50 dark:bg-slate-950 p-4 flex items-center justify-center overflow-hidden group/img">
                            <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="max-h-full object-contain rounded-xl transition duration-500 group-hover/img:scale-105">
                            
                            <!-- Discount Badge -->
                            <span class="absolute top-3.5 left-3.5 bg-red-600 text-white font-bold text-[9px] uppercase tracking-wider px-2 py-0.5 rounded-lg shadow">
                                Save 15%
                            </span>

                            <!-- Wishlist Hover Action -->
                            <button type="button" class="absolute top-3.5 right-3.5 p-2 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-xl shadow-md border border-slate-200/50 dark:border-slate-800/50 text-slate-450 hover:text-red-500 transition duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Card details -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div class="space-y-1.5">
                                <p class="text-[10px] text-blue-600 dark:text-blue-400 font-extrabold uppercase tracking-widest">{{ $product->brand->name ?? 'Brand' }}</p>
                                <a wire:navigate href="{{ route('product-details', $product->slug) }}" class="block font-bold text-slate-850 dark:text-slate-100 hover:text-blue-600 dark:hover:text-blue-400 transition text-sm leading-snug line-clamp-2">
                                    {{ $product->name }}
                                </a>
                            </div>

                            <!-- Pricing and Quick Actions -->
                            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                                <div class="space-y-0.5">
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 line-through">
                                        {{ Number::currency($product->price * 1.15, 'INR') }}
                                    </p>
                                    <p class="text-base font-black text-slate-900 dark:text-white">
                                        {{ Number::currency($product->price, 'INR') }}
                                    </p>
                                </div>
                                
                                <button wire:click.prevent="addToCart({{ $product->id }})" class="py-2 px-3.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl transition shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 flex items-center gap-1.5 text-xs font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
                                    </svg>
                                    <span>Add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- POPULAR CATEGORIES -->
    <div class="py-20 border-b border-slate-200/40 dark:border-slate-800/40 bg-slate-50/50 dark:bg-slate-900/10">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 dark:text-blue-450 font-bold uppercase tracking-widest">Collections</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Shop by Popular Categories
                </h2>
                <div class="w-16 h-1 bg-blue-650 mx-auto rounded"></div>
                <p class="text-slate-550 dark:text-slate-450 text-sm">
                    Find top-tier technology components, mobile units, computing power, and direct high-end audio accessories.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($categories as $index => $category)
                    <a wire:navigate href="/products?selected_categories[0]={{ $category->id }}" class="group relative rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-350 hover:-translate-y-1 block h-[260px] bg-slate-900 border border-slate-800/30" wire:key="category-{{ $category->id }}">
                        <!-- Image with zoom effect -->
                        <div class="absolute inset-0 z-0">
                            <img src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-105 opacity-60">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                        </div>
                        
                        <!-- Overlay Details -->
                        <div class="absolute inset-0 p-8 flex flex-col justify-end z-10">
                            <div class="space-y-1 text-left">
                                <p class="text-xs font-bold text-blue-400 tracking-wider uppercase">Category #{{ $index + 1 }}</p>
                                <h3 class="text-2xl font-black text-white leading-tight">
                                    {{ $category->name }}
                                </h3>
                                <p class="text-xs text-slate-350 flex items-center gap-1.5 mt-1 font-semibold">
                                    Browse collection 
                                    <span class="group-hover:translate-x-1 transition duration-200">→</span>
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- FEATURED PRODUCTS -->
    <div class="py-20 border-b border-slate-200/40 dark:border-slate-800/40 bg-white dark:bg-slate-900/40">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 dark:text-blue-450 font-bold uppercase tracking-widest">Recommended Products</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Featured Technology Showcase
                </h2>
                <div class="w-16 h-1 bg-blue-650 mx-auto rounded"></div>
                <p class="text-slate-550 dark:text-slate-450 text-sm">
                    Discover handpicked devices with industry-leading performance and build qualities.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($featured_products as $product)
                    <div class="group flex flex-col bg-white dark:bg-slate-900 border border-slate-250/60 dark:border-slate-800/60 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300" wire:key="featured-{{ $product->id }}">
                        <!-- Image display with absolute stickers -->
                        <div class="relative aspect-square bg-slate-50 dark:bg-slate-950 p-6 flex items-center justify-center overflow-hidden group/img shrink-0 border-b border-slate-100 dark:border-slate-850">
                            <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="max-h-full object-contain rounded-2xl transition duration-500 group-hover/img:scale-105">
                            
                            <!-- Category Badge -->
                            <span class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur-md text-white font-bold text-[9px] uppercase px-2.5 py-1 rounded-lg">
                                {{ $product->category->name ?? 'Tech' }}
                            </span>

                            <!-- Wishlist Hover Action -->
                            <button type="button" class="absolute top-4 right-4 p-2 bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-850 rounded-xl shadow border border-slate-200/50 dark:border-slate-800/50 text-slate-450 hover:text-red-500 transition duration-200">
                                <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                </svg>
                            </button>
                        </div>

                        <!-- Info details -->
                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between text-[10px] text-slate-400 dark:text-slate-500 font-bold tracking-widest uppercase">
                                    <span>{{ $product->brand->name ?? 'Brand' }}</span>
                                    <!-- Stars mockup -->
                                    <div class="flex items-center gap-1 text-amber-500 font-semibold">
                                        <span>★</span>
                                        <span>4.9</span>
                                    </div>
                                </div>

                                <a wire:navigate href="{{ route('product-details', $product->slug) }}" class="block font-extrabold text-slate-850 dark:text-slate-100 hover:text-blue-600 dark:hover:text-blue-400 transition text-base leading-snug line-clamp-2">
                                    {{ $product->name }}
                                </a>

                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $product->short_description }}
                                </p>
                            </div>

                            <!-- pricing grid -->
                            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-850 flex items-center justify-between gap-4">
                                <div class="space-y-0.5 text-left">
                                    <span class="text-[10px] text-slate-400 uppercase tracking-widest font-bold">Price</span>
                                    <p class="text-lg font-black text-slate-900 dark:text-white leading-none">
                                        {{ Number::currency($product->price, 'INR') }}
                                    </p>
                                </div>

                                <button wire:click.prevent="addToCart({{ $product->id }})" class="py-2.5 px-4.5 bg-slate-900 hover:bg-slate-800 dark:bg-slate-850 dark:hover:bg-slate-750 text-white rounded-xl transition shadow-md shadow-slate-950/10 flex items-center gap-2 text-xs font-bold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- FEATURED COLLECTIONS BANNERS -->
    <div class="py-20 bg-slate-50/50 dark:bg-slate-950">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 dark:text-blue-450 font-bold uppercase tracking-widest">Featured Themes</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Curated Setup Collections
                </h2>
                <div class="w-16 h-1 bg-blue-650 mx-auto rounded"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Creator Studio Banner -->
                <div class="relative rounded-3xl overflow-hidden shadow-md h-[380px] bg-gradient-to-br from-indigo-900 to-slate-950 p-8 flex flex-col justify-between group">
                    <div class="absolute inset-0 z-0">
                        <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=600&q=80" alt="Creator Studio" class="w-full h-full object-cover transition-transform duration-700 opacity-30 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/45 to-transparent"></div>
                    </div>
                    
                    <div class="z-10 text-left">
                        <span class="px-2.5 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/10 text-[9px] uppercase tracking-wider font-bold text-indigo-300">Creator Studio</span>
                    </div>

                    <div class="z-10 space-y-4 text-left">
                        <h3 class="text-2xl font-black text-white leading-tight">Elevate Your Audio & Production Setup</h3>
                        <p class="text-xs text-slate-300">Studio cameras, noise-canceling gear, and high-fidelity devices.</p>
                        <a wire:navigate href="/products?selected_categories[0]=3" class="inline-flex items-center gap-2 py-2.5 px-5 bg-white text-slate-900 rounded-xl font-bold text-xs shadow hover:bg-slate-50 transition duration-200">
                            Shop Audio
                        </a>
                    </div>
                </div>

                <!-- Gaming Setup Banner -->
                <div class="relative rounded-3xl overflow-hidden shadow-md h-[380px] bg-gradient-to-br from-blue-900 to-slate-950 p-8 flex flex-col justify-between group">
                    <div class="absolute inset-0 z-0">
                        <img src="https://images.unsplash.com/photo-1618424181497-157f25b6ddd5?auto=format&fit=crop&w=600&q=80" alt="Gaming Setup" class="w-full h-full object-cover transition-transform duration-700 opacity-30 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/45 to-transparent"></div>
                    </div>
                    
                    <div class="z-10 text-left">
                        <span class="px-2.5 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/10 text-[9px] uppercase tracking-wider font-bold text-blue-300">Next Gen Gaming</span>
                    </div>

                    <div class="z-10 space-y-4 text-left">
                        <h3 class="text-2xl font-black text-white leading-tight">Ultra Gaming & Visual Display Hubs</h3>
                        <p class="text-xs text-slate-300">4K OLED TVs, immersive soundbars, and next-level displays.</p>
                        <a wire:navigate href="/products?selected_categories[0]=5" class="inline-flex items-center gap-2 py-2.5 px-5 bg-white text-slate-900 rounded-xl font-bold text-xs shadow hover:bg-slate-50 transition duration-200">
                            Shop Televisions
                        </a>
                    </div>
                </div>

                <!-- Work From Home Banner -->
                <div class="relative rounded-3xl overflow-hidden shadow-md h-[380px] bg-gradient-to-br from-cyan-900 to-slate-950 p-8 flex flex-col justify-between group">
                    <div class="absolute inset-0 z-0">
                        <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=600&q=80" alt="Work From Home" class="w-full h-full object-cover transition-transform duration-700 opacity-30 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/45 to-transparent"></div>
                    </div>
                    
                    <div class="z-10 text-left">
                        <span class="px-2.5 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/10 text-[9px] uppercase tracking-wider font-bold text-cyan-300">Office Pro</span>
                    </div>

                    <div class="z-10 space-y-4 text-left">
                        <h3 class="text-2xl font-black text-white leading-tight">Authentic Portable Workspace Gear</h3>
                        <p class="text-xs text-slate-300">High-capacity laptops, computers, and multi-port units.</p>
                        <a wire:navigate href="/products?selected_categories[0]=2" class="inline-flex items-center gap-2 py-2.5 px-5 bg-white text-slate-900 rounded-xl font-bold text-xs shadow hover:bg-slate-50 transition duration-200">
                            Shop Laptops
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TRENDING BRANDS -->
    <div class="py-20 border-b border-slate-200/40 dark:border-slate-800/40 bg-white dark:bg-slate-900/40">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 dark:text-blue-450 font-bold uppercase tracking-widest">Brand Partners</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Trending Luxury Brands
                </h2>
                <div class="w-16 h-1 bg-blue-650 mx-auto rounded"></div>
            </div>

            <!-- Brands grid (Dynamic database brands + luxury static placeholders) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Dynamically render existing seeded brands -->
                @foreach ($brands as $brand)
                    <a wire:navigate href="/products?selected_brands[0]={{ $brand->id }}" class="group flex flex-col bg-slate-50/50 dark:bg-slate-850/50 border border-slate-100 dark:border-slate-850 rounded-2xl p-6 hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift text-center" wire:key="brand-{{ $brand->id }}">
                        <div class="h-20 w-full bg-white dark:bg-slate-900 rounded-xl flex items-center justify-center mx-auto mb-3 p-4 shadow-sm border border-slate-100/50 dark:border-slate-800/50">
                            <img class="h-8 w-auto max-w-[120px] object-contain transition duration-300 filter grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100" src="{{ $brand->getImageUrl() }}" alt="{{ $brand->name }}">
                        </div>
                        <h4 class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 text-xs">
                            {{ $brand->name }} Retailer
                        </h4>
                    </a>
                @endforeach

                <!-- Static placeholder cards to complete the 8 requested brands -->
                <div class="group flex flex-col bg-slate-50/50 dark:bg-slate-850/50 border border-slate-100 dark:border-slate-850 rounded-2xl p-6 hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift text-center">
                    <div class="h-20 w-full bg-white dark:bg-slate-900 rounded-xl flex items-center justify-center mx-auto mb-3 p-4 shadow-sm border border-slate-100/50 dark:border-slate-800/50">
                        <img class="h-8 w-auto max-w-[120px] object-contain transition duration-300 filter grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100" src="https://upload.wikimedia.org/wikipedia/commons/2/2f/ASUS_Logo.svg" alt="ASUS">
                    </div>
                    <h4 class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 text-xs">
                        ASUS Store
                    </h4>
                </div>

                <div class="group flex flex-col bg-slate-50/50 dark:bg-slate-850/50 border border-slate-100 dark:border-slate-850 rounded-2xl p-6 hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift text-center">
                    <div class="h-20 w-full bg-white dark:bg-slate-900 rounded-xl flex items-center justify-center mx-auto mb-3 p-4 shadow-sm border border-slate-100/50 dark:border-slate-800/50">
                        <img class="h-6 w-auto max-w-[120px] object-contain transition duration-300 filter grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100" src="https://upload.wikimedia.org/wikipedia/commons/1/17/Logitech_logo.svg" alt="Logitech">
                    </div>
                    <h4 class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 text-xs">
                        Logitech Authorized
                    </h4>
                </div>

                <div class="group flex flex-col bg-slate-50/50 dark:bg-slate-850/50 border border-slate-100 dark:border-slate-850 rounded-2xl p-6 hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift text-center">
                    <div class="h-20 w-full bg-white dark:bg-slate-900 rounded-xl flex items-center justify-center mx-auto mb-3 p-4 shadow-sm border border-slate-100/50 dark:border-slate-800/50">
                        <img class="h-8 w-auto max-w-[120px] object-contain transition duration-300 filter grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100" src="https://upload.wikimedia.org/wikipedia/commons/1/15/Canon_logo.svg" alt="Canon">
                    </div>
                    <h4 class="font-bold text-slate-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 text-xs">
                        Canon Optics
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- WHY CHOOSE BYTEWEBSTER -->
    <div class="py-20 bg-slate-50/50 dark:bg-slate-950 border-b border-slate-200/40 dark:border-slate-800/40">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 dark:text-blue-450 font-bold uppercase tracking-widest">Our Guarantees</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Why Customers Trust ByteWebster
                </h2>
                <div class="w-16 h-1 bg-blue-650 mx-auto rounded"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Card 1 -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/60 shadow-sm hover:shadow-xl transition duration-300 text-left space-y-4">
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-950/30 rounded-xl flex items-center justify-center text-blue-605">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-950 dark:text-white text-base">100% Genuine Products</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">No refurbished units or third-party duplicates. We ship only officially authenticated merchandise in original boxes.</p>
                </div>

                <!-- Card 2 -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/60 shadow-sm hover:shadow-xl transition duration-300 text-left space-y-4">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-950/30 rounded-xl flex items-center justify-center text-indigo-605">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-950 dark:text-white text-base">Fast Express Delivery</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Complimentary insured delivery for active orders. Track packages from processing to final drop-off.</p>
                </div>

                <!-- Card 3 -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/60 shadow-sm hover:shadow-xl transition duration-300 text-left space-y-4">
                    <div class="w-12 h-12 bg-cyan-50 dark:bg-cyan-950/30 rounded-xl flex items-center justify-center text-cyan-605">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-950 dark:text-white text-base">Brand Manufacturer Warranty</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">All devices include official corporate manufacturer warranties. Get direct customer support from the creators.</p>
                </div>

                <!-- Card 4 -->
                <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/60 shadow-sm hover:shadow-xl transition duration-300 text-left space-y-4">
                    <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-950/30 rounded-xl flex items-center justify-center text-emerald-605">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-950 dark:text-white text-base">24/7 Expert Support</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Have custom configuration inquiries? Connect instantly with our tech-expert agents anytime.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CUSTOMER TESTIMONIALS -->
    <div class="py-20 border-b border-slate-200/40 dark:border-slate-800/40 bg-white dark:bg-slate-900/40">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 dark:text-blue-450 font-bold uppercase tracking-widest">Reviews</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Verified Customer Reviews
                </h2>
                <div class="w-16 h-1 bg-blue-650 mx-auto rounded"></div>
            </div>

            <!-- Testimonial Slider grid wrapper -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="p-8 rounded-3xl bg-slate-50/50 dark:bg-slate-850/50 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between text-left space-y-6">
                    <div class="space-y-4">
                        <!-- Rating stars -->
                        <div class="flex text-amber-500 text-sm gap-0.5">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <p class="text-sm text-slate-700 dark:text-slate-350 italic leading-relaxed">
                            "The MacBook Pro arrived in perfect original brand packaging next day. Registering the AppleCare warranty directly on Apple's site was completely smooth. 10/10 purchase!"
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs uppercase">
                            SK
                        </div>
                        <div>
                            <h5 class="text-xs font-black text-slate-805 dark:text-white flex items-center gap-1.5">
                                Sarah K.
                                <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-400 px-1.5 py-0.5 rounded text-[8px] uppercase font-bold tracking-wider">Verified Buyer</span>
                            </h5>
                            <p class="text-[9px] text-slate-450 mt-0.5">Purchased: Apple MacBook Pro 14" M3</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="p-8 rounded-3xl bg-slate-50/50 dark:bg-slate-850/50 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between text-left space-y-6">
                    <div class="space-y-4">
                        <!-- Rating stars -->
                        <div class="flex text-amber-500 text-sm gap-0.5">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <p class="text-sm text-slate-700 dark:text-slate-350 italic leading-relaxed">
                            "I was skeptical about buying high-end audio gear online, but ByteWebster has the real deal. These headphones sounds absolutely amazing and are 100% genuine Sony units."
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-600 to-cyan-600 text-white flex items-center justify-center font-bold text-xs uppercase">
                            RM
                        </div>
                        <div>
                            <h5 class="text-xs font-black text-slate-805 dark:text-white flex items-center gap-1.5">
                                Rajesh M.
                                <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-400 px-1.5 py-0.5 rounded text-[8px] uppercase font-bold tracking-wider">Verified Buyer</span>
                            </h5>
                            <p class="text-[9px] text-slate-450 mt-0.5">Purchased: Sony WH-1000XM5 Wireless</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="p-8 rounded-3xl bg-slate-50/50 dark:bg-slate-850/50 border border-slate-200/50 dark:border-slate-800/50 flex flex-col justify-between text-left space-y-6">
                    <div class="space-y-4">
                        <!-- Rating stars -->
                        <div class="flex text-amber-500 text-sm gap-0.5">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <p class="text-sm text-slate-700 dark:text-slate-350 italic leading-relaxed">
                            "Amazing checkout flow and lightning fast delivery processing. Received my Samsung Galaxy phone next day. Love the service support team. Strongly recommend them!"
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-cyan-600 to-emerald-600 text-white flex items-center justify-center font-bold text-xs uppercase">
                            AS
                        </div>
                        <div>
                            <h5 class="text-xs font-black text-slate-805 dark:text-white flex items-center gap-1.5">
                                Amit S.
                                <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-950/50 dark:text-emerald-400 px-1.5 py-0.5 rounded text-[8px] uppercase font-bold tracking-wider">Verified Buyer</span>
                            </h5>
                            <p class="text-[9px] text-slate-450 mt-0.5">Purchased: Samsung Galaxy S24 Ultra</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- NEWSLETTER SECTION -->
    <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-indigo-50/30 to-slate-50 border-t border-b border-slate-200/60 py-20">
        <!-- background accents -->
        <div class="absolute inset-0 bg-[radial-gradient(#cbd5e1_1px,transparent_1px)] [background-size:24px_24px] opacity-40"></div>
        
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-2xl mx-auto text-center space-y-6">
                <span class="px-3 py-1.5 bg-blue-50 border border-blue-100 rounded-full text-xs font-bold text-blue-600 shadow-sm">Exclusive Newsletter</span>
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight text-slate-900 leading-tight">
                    Unlock Special Member Pricing
                </h2>
                <p class="text-sm text-slate-650 max-w-lg mx-auto leading-relaxed">
                    Subscribe to receive custom direct manufacturer discounts, priority stock notifications, and expert tech content.
                </p>

                <!-- Input form -->
                <form class="max-w-md mx-auto pt-2">
                    <div class="flex flex-col sm:flex-row gap-3 bg-white border border-slate-200/80 p-2 rounded-2xl shadow-sm">
                        <input type="email" placeholder="Enter your business email" class="flex-1 py-3 px-4 bg-transparent border-transparent text-sm focus:outline-none placeholder-slate-405 text-slate-800 rounded-xl">
                        <button type="submit" class="py-3 px-6 bg-blue-650 hover:bg-blue-600 rounded-xl font-bold text-xs text-white shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition-all duration-200">
                            Join Exclusive List
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
