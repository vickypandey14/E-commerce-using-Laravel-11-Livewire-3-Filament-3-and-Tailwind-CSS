<div class="w-full">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/40 py-20 lg:py-28 border-b border-gray-100">
        <!-- Minimal Grid Pattern Background -->
        <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:24px_24px] opacity-60"></div>
        <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-blue-300/10 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-10 w-[500px] h-[500px] bg-indigo-300/10 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-12 gap-12 lg:gap-16 items-center">
                <!-- Left text column (Grid: 7 cols on large screens) -->
                <div class="space-y-8 text-left md:col-span-7">
                    <!-- Status Badge -->
                    <div class="inline-flex items-center gap-2 py-1.5 px-3.5 rounded-full text-xs font-semibold bg-white border border-slate-200/80 shadow-sm text-slate-800 backdrop-blur-sm">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        100% Genuine Electronics & Tech
                    </div>

                    <!-- Direct Headline -->
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-slate-900 leading-[1.1]">
                        Sleek, Genuine Electronics. <br/>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Direct From Top Brands.</span>
                    </h1>

                    <!-- Clear Subheadline -->
                    <p class="text-lg text-slate-600 max-w-xl leading-relaxed">
                        Skip the markup and purchase directly from the manufacturers you trust. We stock only authentic smartphones, laptops, audio gear, and accessories with full warranty support.
                    </p>
                    
                    <!-- Call to Action Buttons -->
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a wire:navigate href="/products" class="py-3.5 px-7 inline-flex justify-center items-center gap-x-2.5 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-lg shadow-blue-500/10 hover:shadow-blue-500/20 hover:-translate-y-0.5 transition duration-200">
                            Browse Products
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                            </svg>
                        </a>
                        <a wire:navigate href="/categories" class="py-3.5 px-7 inline-flex justify-center items-center gap-x-2.5 text-sm font-semibold rounded-xl border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 shadow-sm hover:-translate-y-0.5 transition duration-200">
                            Shop Categories
                        </a>
                    </div>

                    <!-- Clean Trust Badges -->
                    <div class="grid grid-cols-3 gap-6 pt-8 border-t border-slate-200/80 max-w-md">
                        <div>
                            <p class="text-3xl font-extrabold text-blue-600 tracking-tight">100%</p>
                            <p class="text-xs font-medium text-slate-500 mt-1">Authorized Dealer</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold text-indigo-600 tracking-tight">24/7</p>
                            <p class="text-xs font-medium text-slate-500 mt-1">Direct Support</p>
                        </div>
                        <div>
                            <p class="text-3xl font-extrabold text-cyan-600 tracking-tight">Free</p>
                            <p class="text-xs font-medium text-slate-500 mt-1">Express Shipping</p>
                        </div>
                    </div>
                </div>

                <!-- Right visual column (Grid: 5 cols on large screens) -->
                <div class="relative md:col-span-5 flex justify-center items-center lg:pl-4">
                    <!-- Subtle Glow Ring behind Image -->
                    <div class="absolute -inset-1 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-3xl opacity-10 blur-xl"></div>
                    
                    <!-- Main Showcase Container -->
                    <div class="relative w-full max-w-[420px] aspect-[4/5] sm:aspect-square md:aspect-[4/5] lg:aspect-square rounded-3xl overflow-hidden shadow-2xl border border-slate-200/80 bg-white p-2.5 transition duration-300 hover:shadow-blue-500/5 group">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 via-transparent to-transparent z-10 rounded-2.5xl pointer-events-none"></div>
                        <img 
                            src="https://images.unsplash.com/photo-1468495244123-6c6c332eeece?auto=format&fit=crop&w=1000&q=80" 
                            alt="Premium Technology Electronics Showcase" 
                            class="w-full h-full object-cover rounded-2.5xl transition-transform duration-700 ease-out group-hover:scale-105"
                        />
                    </div>

                    <!-- Floating Card 1: Sony Headphones Badge -->
                    <div class="absolute -top-6 -left-6 bg-white/95 backdrop-blur-md border border-slate-200/60 p-3.5 rounded-2xl shadow-xl flex items-center gap-3 transition-transform duration-300 hover:-translate-y-1 max-w-[210px] hidden sm:flex">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-lg shadow-inner">
                            🎧
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">Sony WH-1000XM4</p>
                            <div class="flex items-center gap-1 mt-0.5">
                                <span class="text-amber-500 text-xs">★</span>
                                <span class="text-[10px] font-semibold text-slate-500">4.9 (2.4k+ reviews)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Card 2: Warranty Badge -->
                    <div class="absolute bottom-6 -right-6 bg-white/95 backdrop-blur-md border border-slate-200/60 p-3.5 rounded-2xl shadow-xl flex items-center gap-3 transition-transform duration-300 hover:-translate-y-1 max-w-[220px] hidden sm:flex">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shadow-inner">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-800">2-Year Official Warranty</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Direct manufacturer support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Value Propositions -->
    <div class="bg-white border-b border-gray-100 py-14">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Delivery Proposition -->
                <div class="flex gap-4 items-start p-4 rounded-2xl hover:bg-slate-50/50 transition">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Free Express Shipping</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Enjoy complimentary express delivery on orders. Shipped securely and insured directly to your door.</p>
                    </div>
                </div>

                <!-- Safe Checkout Proposition -->
                <div class="flex gap-4 items-start p-4 rounded-2xl hover:bg-slate-50/50 transition">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Encrypted Safe Checkout</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Your payment information is fully encrypted. We accept all major cards, bank transfers, and cash on delivery.</p>
                    </div>
                </div>

                <!-- Returns Proposition -->
                <div class="flex gap-4 items-start p-4 rounded-2xl hover:bg-slate-50/50 transition">
                    <div class="p-3 bg-cyan-50 text-cyan-600 rounded-xl">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 1121.21 8H17" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Simple 30-Day Returns</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Not completely satisfied with your item? Return it in its original packaging within 30 days for a hassle-free exchange.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Browse Categories Section -->
    <div class="py-20 bg-slate-50">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 font-bold uppercase tracking-widest">Collections</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight">
                    Featured Categories
                </h2>
                <div class="w-16 h-1 bg-blue-600 mx-auto rounded"></div>
                <p class="text-slate-500 text-sm">
                    Select a category to see our full list of products.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($categories as $category)
                    <a wire:navigate href="/products?selected_categories[0]={{ $category->id }}" class="group flex flex-col bg-white border border-gray-100 rounded-2xl p-5 hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift text-center" wire:key="category-{{ $category->id }}">
                        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow-sm">
                            <img class="h-10 w-10 object-contain rounded-lg" src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}">
                        </div>
                        <h3 class="font-bold text-slate-800 group-hover:text-blue-600 transition text-sm">
                            {{ $category->name }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Browse Popular Brands Section -->
    <div class="py-20 bg-white">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 font-bold uppercase tracking-widest">Top Manufacturers</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight">
                    Popular Brands
                </h2>
                <div class="w-16 h-1 bg-blue-600 mx-auto rounded"></div>
                <p class="text-slate-500 text-sm">
                    Shop genuine high-quality items made by your favorite technology brands.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($brands as $brand)
                    <a wire:navigate href="/products?selected_brands[0]={{ $brand->id }}" class="group flex flex-col bg-slate-50 border border-gray-100 rounded-2xl p-5 hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift text-center" wire:key="brand-{{ $brand->id }}">
                        <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow-sm border border-gray-100">
                            <img class="h-10 w-10 object-contain rounded-full" src="{{ $brand->getImageUrl() }}" alt="{{ $brand->name }}">
                        </div>
                        <h3 class="font-bold text-slate-800 group-hover:text-blue-600 transition text-sm">
                            {{ $brand->name }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
