<div class="w-full bg-slate-50 text-slate-800 min-h-screen pb-16">
    <!-- 1. QUICK CATEGORIES BAR -->
    <div class="bg-white border-b border-slate-200 py-4 mb-6 shadow-sm">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-start sm:justify-center gap-6 md:gap-12 overflow-x-auto scrollbar-hide">
                @foreach($categories as $category)
                    <a wire:navigate href="/products?selected_categories[0]={{ $category->id }}" class="flex flex-col items-center gap-2 shrink-0 group">
                        <div class="w-14 h-14 rounded-full bg-slate-50 border border-slate-150 flex items-center justify-center group-hover:border-blue-500 group-hover:bg-blue-50/50 transition duration-300 shadow-sm">
                            <img src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}" class="w-8 h-8 object-contain group-hover:scale-110 transition duration-300">
                        </div>
                        <span class="text-xs font-bold text-slate-700 group-hover:text-blue-600 transition">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 2. HERO SECTION: SLIDER & SIDE PROMOS -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Alpine.js Main Slider (2/3 width on desktop) -->
            <div class="col-span-12 lg:col-span-8">
                <div x-data="{ 
                    activeSlide: 0, 
                    slidesCount: 3,
                    autoplay() {
                        setInterval(() => {
                            this.activeSlide = (this.activeSlide === this.slidesCount - 1) ? 0 : this.activeSlide + 1;
                        }, 6000);
                    }
                }" x-init="autoplay()" class="relative w-full h-[280px] sm:h-[320px] md:h-[340px] rounded-3xl overflow-hidden shadow-sm border border-slate-200 bg-white group">
                    
                    <!-- Slide 1: Apple -->
                    <div x-show="activeSlide === 0" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 scale-98"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute inset-0 w-full h-full bg-gradient-to-r from-blue-50/70 via-indigo-50/40 to-slate-50 flex items-center p-6 sm:p-10 md:p-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center w-full">
                            <div class="text-left space-y-2 sm:space-y-4">
                                <span class="inline-flex py-1 px-2.5 rounded-lg bg-blue-50 text-blue-700 font-bold text-[10px] uppercase tracking-wider border border-blue-100">Official Brand Premium</span>
                                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">Genuine Apple Devices</h2>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-sm">Shop official iPhones and MacBooks with direct manufacturer warranty coverage.</p>
                                <div class="pt-2">
                                    <a @if($hero_products['apple']) href="{{ route('product-details', $hero_products['apple']->slug) }}" @else href="/products?selected_brands[0]=1" @endif class="py-2.5 px-5 inline-flex justify-center items-center gap-x-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-500 text-white shadow-md shadow-blue-500/10 transition-all duration-200">
                                        Shop Apple Store
                                    </a>
                                </div>
                            </div>
                            <div class="hidden md:flex justify-center items-center h-full">
                                @if($hero_products['apple'])
                                    <img src="{{ $hero_products['apple']->getImageUrl() }}" alt="Apple Hero" class="max-h-[190px] lg:max-h-[220px] w-auto object-contain drop-shadow-xl hover:scale-105 transition duration-300 select-none">
                                @else
                                    <img src="https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?auto=format&fit=crop&w=600&q=80" alt="Apple Hero" class="max-h-[190px] lg:max-h-[220px] w-auto object-contain drop-shadow-xl hover:scale-105 transition duration-300 select-none">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Sony -->
                    <div x-show="activeSlide === 1" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 scale-98"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute inset-0 w-full h-full bg-gradient-to-r from-slate-50 via-indigo-50/30 to-blue-50 flex items-center p-6 sm:p-10 md:p-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center w-full">
                            <div class="text-left space-y-2 sm:space-y-4">
                                <span class="inline-flex py-1 px-2.5 rounded-lg bg-indigo-50 text-indigo-700 font-bold text-[10px] uppercase tracking-wider border border-indigo-100">Premium Audio Offer</span>
                                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">Sony Audio Innovations</h2>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-sm">Save up to 15% on noise canceling headphones and earbuds. Direct brand warranty.</p>
                                <div class="pt-2">
                                    <a @if($hero_products['sony']) href="{{ route('product-details', $hero_products['sony']->slug) }}" @else href="/products?selected_brands[0]=3" @endif class="py-2.5 px-5 inline-flex justify-center items-center gap-x-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-500 text-white shadow-md shadow-blue-500/10 transition-all duration-200">
                                        Shop Sony Audio
                                    </a>
                                </div>
                            </div>
                            <div class="hidden md:flex justify-center items-center h-full">
                                @if($hero_products['sony'])
                                    <img src="{{ $hero_products['sony']->getImageUrl() }}" alt="Sony Hero" class="max-h-[190px] lg:max-h-[220px] w-auto object-contain drop-shadow-xl hover:scale-105 transition duration-300 select-none">
                                @else
                                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80" alt="Sony Hero" class="max-h-[190px] lg:max-h-[220px] w-auto object-contain drop-shadow-xl hover:scale-105 transition duration-300 select-none">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Samsung -->
                    <div x-show="activeSlide === 2" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0 scale-98"
                         x-transition:enter-end="opacity-100 scale-100"
                         class="absolute inset-0 w-full h-full bg-gradient-to-r from-emerald-50/50 via-slate-50 to-blue-50/60 flex items-center p-6 sm:p-10 md:p-12">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center w-full">
                            <div class="text-left space-y-2 sm:space-y-4">
                                <span class="inline-flex py-1 px-2.5 rounded-lg bg-emerald-50 text-emerald-700 font-bold text-[10px] uppercase tracking-wider border border-emerald-100">Galaxy Spotlight Deal</span>
                                <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">Samsung Galaxy Deals</h2>
                                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-sm">Experience the next level of mobile productivity, LTE Watches & flagships.</p>
                                <div class="pt-2">
                                    <a @if($hero_products['samsung']) href="{{ route('product-details', $hero_products['samsung']->slug) }}" @else href="/products?selected_brands[0]=2" @endif class="py-2.5 px-5 inline-flex justify-center items-center gap-x-2 text-xs font-bold rounded-xl bg-blue-600 hover:bg-blue-500 text-white shadow-md shadow-blue-500/10 transition-all duration-200">
                                        Shop Samsung Store
                                    </a>
                                </div>
                            </div>
                            <div class="hidden md:flex justify-center items-center h-full">
                                @if($hero_products['samsung'])
                                    <img src="{{ $hero_products['samsung']->getImageUrl() }}" alt="Samsung Hero" class="max-h-[190px] lg:max-h-[220px] w-auto object-contain drop-shadow-xl hover:scale-105 transition duration-300 select-none">
                                @else
                                    <img src="https://images.unsplash.com/photo-1610945265064-0e34e5519bbf?auto=format&fit=crop&w=600&q=80" alt="Samsung Hero" class="max-h-[190px] lg:max-h-[220px] w-auto object-contain drop-shadow-xl hover:scale-105 transition duration-300 select-none">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Slide Navigation Arrows -->
                    <button @click="activeSlide = (activeSlide === 0) ? slidesCount - 1 : activeSlide - 1" class="absolute top-1/2 left-4 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 hover:bg-white border border-slate-200 text-slate-700 flex items-center justify-center shadow-sm transition opacity-0 group-hover:opacity-100 z-10">
                        &larr;
                    </button>
                    <button @click="activeSlide = (activeSlide === slidesCount - 1) ? 0 : activeSlide + 1" class="absolute top-1/2 right-4 -translate-y-1/2 w-8 h-8 rounded-full bg-white/80 hover:bg-white border border-slate-200 text-slate-700 flex items-center justify-center shadow-sm transition opacity-0 group-hover:opacity-100 z-10">
                        &rarr;
                    </button>

                    <!-- Indicators Dots -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-1.5 z-10">
                        <button @click="activeSlide = 0" :class="activeSlide === 0 ? 'bg-blue-600 w-5' : 'bg-slate-300 w-1.5'" class="h-1.5 rounded-full transition-all duration-300"></button>
                        <button @click="activeSlide = 1" :class="activeSlide === 1 ? 'bg-blue-600 w-5' : 'bg-slate-300 w-1.5'" class="h-1.5 rounded-full transition-all duration-300"></button>
                        <button @click="activeSlide = 2" :class="activeSlide === 2 ? 'bg-blue-600 w-5' : 'bg-slate-300 w-1.5'" class="h-1.5 rounded-full transition-all duration-300"></button>
                    </div>
                </div>
            </div>

            <!-- Static Banners (1/3 width on desktop, side-by-side on mobile) -->
            <div class="col-span-12 lg:col-span-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                <!-- Promo 1: Laptops Category Link -->
                <a href="/products?selected_categories[0]=2" class="group relative overflow-hidden bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-3xl p-6 flex flex-col justify-between h-[132px] sm:h-[150px] lg:h-[162px] shadow-sm hover:shadow-md transition">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition duration-500"></div>
                    <div class="absolute right-4 bottom-4 w-16 h-16 opacity-20 group-hover:opacity-30 group-hover:scale-110 transition duration-300 text-5xl shrink-0 select-none flex items-center justify-center">
                        <i class="bi bi-laptop text-5xl"></i>
                    </div>
                    <div class="z-10 text-left space-y-1">
                        <span class="inline-flex px-2 py-0.5 rounded bg-white/20 text-white text-[9px] font-bold uppercase tracking-wider">Computers & Laptops</span>
                        <h3 class="font-extrabold text-base sm:text-lg leading-tight">Flat 40% Off Laptops</h3>
                        <p class="text-[11px] text-blue-100">Premium workstations & accessories</p>
                    </div>
                    <span class="z-10 text-xs font-bold text-white group-hover:underline inline-flex items-center gap-1">Shop Laptops &rarr;</span>
                </a>

                <!-- Promo 2: Smartwatches Category Link -->
                <a href="/products?selected_categories[0]=4" class="group relative overflow-hidden bg-gradient-to-br from-rose-500 to-orange-600 text-white rounded-3xl p-6 flex flex-col justify-between h-[132px] sm:h-[150px] lg:h-[162px] shadow-sm hover:shadow-md transition">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-xl group-hover:scale-125 transition duration-500"></div>
                    <div class="absolute right-4 bottom-4 w-16 h-16 opacity-20 group-hover:opacity-30 group-hover:scale-110 transition duration-300 text-5xl shrink-0 select-none flex items-center justify-center">
                        <i class="bi bi-watch text-5xl"></i>
                    </div>
                    <div class="z-10 text-left space-y-1">
                        <span class="inline-flex px-2 py-0.5 rounded bg-white/20 text-white text-[9px] font-bold uppercase tracking-wider">Fitness & Wearables</span>
                        <h3 class="font-extrabold text-base sm:text-lg leading-tight">Next-Gen Wearables</h3>
                        <p class="text-[11px] text-rose-100">Extra 10% instant checkout discount</p>
                    </div>
                    <span class="z-10 text-xs font-bold text-white group-hover:underline inline-flex items-center gap-1">Shop Wearables &rarr;</span>
                </a>
            </div>

        </div>
    </div>

    <!-- 3. BRAND SPOTLIGHT MINI CARDS -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Promo 1: Apple Brand Spotlight -->
            <a href="/products?selected_brands[0]=1" class="group flex items-center justify-between p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="text-left space-y-1">
                    <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest">Brand Spotlight</span>
                    <h4 class="font-extrabold text-slate-900 text-base">Apple Store</h4>
                    <p class="text-xs text-slate-500">Explore iPhones & Laptops</p>
                </div>
                <img src="https://logo.clearbit.com/apple.com" class="h-8 w-8 object-contain opacity-70 group-hover:opacity-100 transition duration-300 rounded-md" alt="Apple">
            </a>
            <!-- Promo 2: Sony Brand Spotlight -->
            <a href="/products?selected_brands[0]=3" class="group flex items-center justify-between p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="text-left space-y-1">
                    <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest">Premium Audio</span>
                    <h4 class="font-extrabold text-slate-900 text-base">Sony Series</h4>
                    <p class="text-xs text-slate-500">Noise-canceling headsets</p>
                </div>
                <img src="https://logo.clearbit.com/sony.com" class="h-8 w-8 object-contain opacity-70 group-hover:opacity-100 transition duration-300 rounded-md" alt="Sony">
            </a>
            <!-- Promo 3: Samsung Brand Spotlight -->
            <a href="/products?selected_brands[0]=2" class="group flex items-center justify-between p-6 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-md transition">
                <div class="text-left space-y-1">
                    <span class="text-[9px] font-bold text-blue-600 uppercase tracking-widest">Mobile & Smart Hub</span>
                    <h4 class="font-extrabold text-slate-900 text-base">Samsung Galaxy</h4>
                    <p class="text-xs text-slate-500">Android Flagships & LTE Watch</p>
                </div>
                <img src="https://logo.clearbit.com/samsung.com" class="h-8 w-8 object-contain opacity-70 group-hover:opacity-100 transition duration-300 rounded-md" alt="Samsung">
            </a>
        </div>
    </div>

    <!-- 4. FLASH SALE PRODUCTS SECTION -->
    <div class="py-16 bg-white border-y border-slate-200 mb-16">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 mb-10">
                <div class="space-y-1 text-left">
                    <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg bg-red-50 text-red-600 border border-red-100 font-bold text-xs">
                        <i class="bi bi-lightning-charge-fill"></i> Limited Period Flash Sale Offers
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-950">
                        Top Flash Sale Products
                    </h2>
                </div>

                <!-- Timer countdown (Dynamic using Alpine.js) -->
                <div x-data="{
                    timer: {
                        hours: 4,
                        minutes: 32,
                        seconds: 15,
                        init() {
                            setInterval(() => {
                                if (this.seconds > 0) {
                                    this.seconds--;
                                } else {
                                    this.seconds = 59;
                                    if (this.minutes > 0) {
                                        this.minutes--;
                                    } else {
                                        this.minutes = 59;
                                        if (this.hours > 0) {
                                            this.hours--;
                                        } else {
                                            this.hours = 0;
                                            this.minutes = 0;
                                            this.seconds = 0;
                                        }
                                    }
                                }
                            }, 1000);
                        }
                    }
                }" class="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-200 shadow-sm">
                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest pl-1 mr-1">Ends In</span>
                    <div class="flex items-center gap-1">
                        <div class="w-8 h-8 rounded-lg bg-red-600 text-white flex items-center justify-center font-bold text-xs" x-text="String(timer.hours).padStart(2, '0')">04</div>
                        <span class="font-bold text-slate-400">:</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-xs" x-text="String(timer.minutes).padStart(2, '0')">32</div>
                        <span class="font-bold text-slate-400">:</span>
                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center font-bold text-xs animate-pulse" x-text="String(timer.seconds).padStart(2, '0')">15</div>
                    </div>
                </div>
            </div>

            <!-- Flash Sale Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($flash_deals as $product)
                    <div class="group bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between" wire:key="deal-{{ $product->id }}">
                        
                        <!-- Image Area -->
                        <div class="relative aspect-[4/3] bg-slate-50/50 p-6 flex items-center justify-center overflow-hidden border-b border-slate-100">
                            <!-- Discount Badge -->
                            <div class="absolute top-4 left-4 z-10">
                                <span class="inline-flex items-center gap-1 py-1 px-2.5 rounded-full bg-red-500 text-white font-extrabold text-[10px] uppercase tracking-wider shadow-sm">
                                    15% OFF
                                </span>
                            </div>
                            
                            <!-- Image (Clickable & Zoom on Hover) -->
                            <a wire:navigate href="{{ route('product-details', $product->slug) }}" class="w-full h-full flex items-center justify-center">
                                <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="max-h-full object-contain transform group-hover:scale-105 transition-transform duration-500 ease-out select-none">
                            </a>
                        </div>

                        <!-- Details Container -->
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4 text-left">
                            <div class="space-y-2">
                                <!-- Brand & Stars Row -->
                                <div class="flex items-center justify-between text-[10px]">
                                    <span class="font-extrabold text-blue-600 uppercase tracking-widest">{{ $product->brand->name ?? 'Brand' }}</span>
                                    <div class="flex items-center gap-1 bg-amber-50 text-amber-700 font-bold px-2 py-0.5 rounded-md border border-amber-100">
                                        <span>★</span>
                                        <span>{{ number_format(4.5 + ($product->id % 5) / 10, 1) }}</span>
                                    </div>
                                </div>
                                
                                <!-- Title -->
                                <a wire:navigate href="{{ route('product-details', $product->slug) }}" class="block font-bold text-slate-850 hover:text-blue-600 transition text-sm sm:text-base leading-snug line-clamp-2">
                                    {{ $product->name }}
                                </a>
                                
                                <span class="inline-block text-[10px] text-slate-400 font-medium">Official global version model</span>
                            </div>

                            <!-- Inventory Progress Bar Widget -->
                            <div class="space-y-1.5 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                <div class="flex justify-between text-[10px] font-bold">
                                    <span class="text-slate-400">Stock Available</span>
                                    <span class="text-red-500">Only {{ ($product->id % 6) + 2 }} left in stock!</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-red-500 to-orange-500 rounded-full" style="width: {{ (($product->id % 6) + 2) * 12 }}%"></div>
                                </div>
                            </div>

                            <!-- Pricing & Button Row -->
                            <div class="pt-4 border-t border-slate-150 flex items-center justify-between gap-4">
                                <div class="space-y-0.5">
                                    <span class="block text-[9px] text-slate-400 uppercase tracking-widest font-bold">Sale Price</span>
                                    <div class="flex items-baseline gap-1.5">
                                        <p class="text-lg font-black text-slate-905 leading-none">
                                            {{ Number::currency($product->price, 'INR') }}
                                        </p>
                                        <p class="text-[10px] text-slate-400 line-through">
                                            {{ Number::currency($product->price * 1.15, 'INR') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Add to Cart -->
                                <button wire:click.prevent="addToCart({{ $product->id }})" class="py-2.5 px-4 bg-blue-600 hover:bg-blue-500 text-white rounded-xl transition shadow-sm flex items-center gap-1.5 text-xs font-bold whitespace-nowrap">
                                    <svg wire:loading.remove wire:target="addToCart({{ $product->id }})" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
                                    </svg>
                                    <!-- Loading Spinner -->
                                    <svg wire:loading wire:target="addToCart({{ $product->id }})" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add</span>
                                    <span wire:loading wire:target="addToCart({{ $product->id }})">...</span>
                                </button>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 5. FEATURED PRODUCTS GRID -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="text-left space-y-1 mb-10 border-b border-slate-200 pb-4">
            <span class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">Recommended Products</span>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-905">
                Featured Brand Technology
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($featured_products as $product)
                <div class="group flex flex-col bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300" wire:key="featured-{{ $product->id }}">
                    
                    <!-- Clickable Image Product Details link -->
                    <a wire:navigate href="{{ route('product-details', $product->slug) }}" class="relative aspect-square bg-slate-50 p-6 flex items-center justify-center overflow-hidden border-b border-slate-150 shrink-0 block">
                        <img src="{{ $product->getImageUrl() }}" alt="{{ $product->name }}" class="max-h-full object-contain rounded-xl transition duration-500 group-hover:scale-105">
                        <span class="absolute top-4 left-4 bg-slate-900 text-white font-bold text-[9px] uppercase px-2 py-0.5 rounded-md">
                            {{ $product->category->name ?? 'Tech' }}
                        </span>
                    </a>

                    <!-- Details -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div class="space-y-1.5 text-left">
                            <div class="flex items-center justify-between text-[9px] text-slate-400 font-extrabold uppercase tracking-widest">
                                <span>{{ $product->brand->name ?? 'Brand' }}</span>
                                <div class="flex items-center gap-0.5 text-amber-500 font-bold">
                                    <span>★</span>
                                    <span>4.9</span>
                                </div>
                            </div>
                            <a wire:navigate href="{{ route('product-details', $product->slug) }}" class="block font-bold text-slate-900 hover:text-blue-600 transition text-sm sm:text-base leading-snug line-clamp-2">
                                {{ $product->name }}
                            </a>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <!-- pricing grid -->
                        <div class="pt-4 border-t border-slate-150 flex items-center justify-between gap-4">
                            <div class="space-y-0.5 text-left">
                                <span class="text-[9px] text-slate-400 uppercase tracking-widest font-bold">Price</span>
                                <p class="text-base font-black text-slate-900 leading-none">
                                    {{ Number::currency($product->price, 'INR') }}
                                </p>
                            </div>

                            <button wire:click.prevent="addToCart({{ $product->id }})" class="py-2.5 px-3.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl transition shadow flex items-center gap-1.5 text-xs font-bold whitespace-nowrap">
                                <svg wire:loading.remove wire:target="addToCart({{ $product->id }})" class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
                                </svg>
                                <!-- Loading Spinner -->
                                <svg wire:loading wire:target="addToCart({{ $product->id }})" class="animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="addToCart({{ $product->id }})">Add to Cart</span>
                                <span wire:loading wire:target="addToCart({{ $product->id }})">Adding...</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- 6. TRENDING BRANDS -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="text-left space-y-1 mb-10 border-b border-slate-200 pb-4">
            <span class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">Brand Partners</span>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-950">
                Shop Authentic Brands
            </h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach ($brands as $brand)
                <a wire:navigate href="/products?selected_brands[0]={{ $brand->id }}" class="group flex flex-col bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-md transition text-center" wire:key="brand-{{ $brand->id }}">
                    <div class="h-16 w-full bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3 p-4 border border-slate-100">
                        <img class="h-7 w-auto max-w-[120px] object-contain transition duration-300 filter grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100" src="{{ $brand->getImageUrl() }}" alt="{{ $brand->name }}">
                    </div>
                    <span class="font-bold text-slate-700 text-xs">
                        Official {{ $brand->name }} Store
                    </span>
                </a>
            @endforeach

            <!-- Logitech Listing -->
            <a href="/products?search=Logitech" class="group flex flex-col bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-md transition text-center">
                <div class="h-16 w-full bg-slate-50 rounded-xl flex items-center justify-center mx-auto mb-3 p-4 border border-slate-100">
                    <img class="h-5 w-auto max-w-[120px] object-contain transition duration-300 filter grayscale group-hover:grayscale-0 opacity-60 group-hover:opacity-100" src="https://upload.wikimedia.org/wikipedia/commons/1/17/Logitech_logo.svg" alt="Logitech">
                </div>
                <span class="font-bold text-slate-700 text-xs">
                    Logitech Gear
                </span>
            </a>
        </div>
    </div>

    <!-- 7. WHY CHOOSE BYTEWEBSTER GUARANTEES -->
    <div class="py-16 bg-white border-y border-slate-200 mb-16">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Guarantee 1 -->
                <div class="flex gap-4 items-start text-left">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl border border-blue-100 shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-sm">100% Authentic</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Direct manufacturer stocks in original sealed boxing only.</p>
                    </div>
                </div>

                <!-- Guarantee 2 -->
                <div class="flex gap-4 items-start text-left">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl border border-blue-100 shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-sm">Free Express Shipping</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Insured delivery for all orders processes within 24 hours.</p>
                    </div>
                </div>

                <!-- Guarantee 3 -->
                <div class="flex gap-4 items-start text-left">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl border border-blue-100 shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-sm">Official Warranties</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Secure full manufacturer warranty coverage globally.</p>
                    </div>
                </div>

                <!-- Guarantee 4 -->
                <div class="flex gap-4 items-start text-left">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl border border-blue-100 shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h4 class="font-bold text-slate-900 text-sm">24/7 Tech Help</h4>
                        <p class="text-xs text-slate-500 leading-relaxed">Direct support lines with technology configuration experts.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 8. CUSTOMER REVIEWS -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 mb-16">
        <div class="text-left space-y-1 mb-10 border-b border-slate-200 pb-4">
            <span class="text-[10px] text-blue-600 font-bold uppercase tracking-widest">Reviews</span>
            <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-slate-950">
                Customer Testimonials
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Review 1 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col justify-between text-left space-y-6">
                <div class="space-y-3">
                    <div class="flex text-amber-500 text-xs">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <p class="text-xs text-slate-650 leading-relaxed italic">
                        "The MacBook Pro arrived in perfect original brand packaging next day. Registering the AppleCare warranty directly on Apple's site was completely smooth. 10/10 purchase!"
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-650 to-indigo-650 text-white flex items-center justify-center font-bold text-[10px]">
                        SK
                    </div>
                    <div>
                        <h5 class="text-[11px] font-black text-slate-800">Sarah K.</h5>
                        <p class="text-[9px] text-slate-400 mt-0.5">Purchased: Apple MacBook Pro 14"</p>
                    </div>
                </div>
            </div>

            <!-- Review 2 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col justify-between text-left space-y-6">
                <div class="space-y-3">
                    <div class="flex text-amber-500 text-xs">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <p class="text-xs text-slate-650 leading-relaxed italic">
                        "I was skeptical about buying high-end audio gear online, but ByteWebster has the real deal. These headphones sounds absolutely amazing and are 100% genuine Sony units."
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-cyan-650 text-white flex items-center justify-center font-bold text-[10px]">
                        RM
                    </div>
                    <div>
                        <h5 class="text-[11px] font-black text-slate-800">Rajesh M.</h5>
                        <p class="text-[9px] text-slate-400 mt-0.5">Purchased: Sony WH-1000XM5 Headphones</p>
                    </div>
                </div>
            </div>

            <!-- Review 3 -->
            <div class="p-6 rounded-2xl bg-white border border-slate-200 flex flex-col justify-between text-left space-y-6">
                <div class="space-y-3">
                    <div class="flex text-amber-500 text-xs">
                        <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                    </div>
                    <p class="text-xs text-slate-650 leading-relaxed italic">
                        "Amazing checkout flow and lightning fast delivery processing. Received my Samsung Galaxy phone next day. Love the service support team. Strongly recommend them!"
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-cyan-600 to-emerald-650 text-white flex items-center justify-center font-bold text-[10px]">
                        AS
                    </div>
                    <div>
                        <h5 class="text-[11px] font-black text-slate-800">Amit S.</h5>
                        <p class="text-[9px] text-slate-400 mt-0.5">Purchased: Samsung Galaxy S24 Ultra</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 9. NEWSLETTER SECTION -->
    <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden bg-gradient-to-br from-blue-50 via-indigo-50/20 to-slate-50 border border-slate-200 py-16 px-6 sm:px-12 rounded-3xl text-center space-y-6">
            <span class="inline-flex py-1 px-3 bg-blue-50 border border-blue-100 rounded-full text-[10px] font-bold text-blue-600 shadow-sm uppercase tracking-wider mx-auto">Store Updates</span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                Unlock Special Member Pricing
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 max-w-lg mx-auto leading-relaxed">
                Subscribe to receive custom direct manufacturer discounts, priority stock notifications, and expert tech content.
            </p>

            <!-- Input form -->
            <form class="max-w-md mx-auto pt-2">
                <div class="flex flex-col sm:flex-row gap-3 bg-white border border-slate-200 p-2 rounded-2xl shadow-sm">
                    <input type="email" placeholder="Enter your business email" class="flex-1 py-2.5 px-4 bg-transparent border-transparent text-sm focus:outline-none placeholder-slate-400 text-slate-800 rounded-xl">
                    <button type="submit" class="py-2.5 px-5 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold text-xs text-white shadow transition-all duration-200">
                        Join Exclusive List
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
