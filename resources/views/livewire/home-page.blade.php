<div class="w-full">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-slate-900 py-20 lg:py-32">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-blue-900/40 via-slate-900 to-slate-950 -z-10"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-blue-500/10 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 text-left">
                    <div class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        ⚡ New Arrivals this week
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                        Elevate Your Tech Game with <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">ByteWebster</span>
                    </h1>
                    <p class="text-lg text-slate-300 max-w-lg">
                        Explore our curated selection of high-end smartphones, computers, wearable tech, and smart home appliances. Engineered for tomorrow.
                    </p>
                    
                    <!-- Call to Action Buttons -->
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a wire:navigate href="/products" class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 transition hover-lift">
                            Shop Products
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                            </svg>
                        </a>
                        <a wire:navigate href="/categories" class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-xl border border-slate-700 bg-slate-800/50 text-white hover:bg-slate-800 transition">
                            Explore Categories
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-800/80">
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-blue-400">99.8%</p>
                            <p class="text-xs text-slate-400 mt-1">Satisfaction Rate</p>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-cyan-400">24/7</p>
                            <p class="text-xs text-slate-400 mt-1">Expert Support</p>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-indigo-400">Free</p>
                            <p class="text-xs text-slate-400 mt-1">Express Delivery</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Interactive Image Banner -->
                <div class="relative flex justify-center items-center">
                    <div class="relative w-full max-w-[450px] aspect-square rounded-3xl overflow-hidden shadow-2xl border border-slate-800 bg-slate-900/60 p-6 flex flex-col justify-between hover-scale">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent z-10"></div>
                        
                        <!-- Top details -->
                        <div class="flex justify-between items-start z-20">
                            <span class="bg-indigo-600 text-white font-bold text-xs px-2.5 py-1 rounded-full uppercase tracking-wider">Premium Series</span>
                            <div class="w-10 h-10 rounded-full bg-slate-800/90 flex items-center justify-center text-white backdrop-blur-md">
                                🛒
                            </div>
                        </div>

                        <!-- Mid Product Card Mockup -->
                        <div class="my-auto z-20 space-y-2 flex flex-col items-center">
                            <div class="w-48 h-48 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-6xl shadow-xl shadow-blue-500/20 transform rotate-3 hover:rotate-0 transition duration-300">
                                📱
                            </div>
                        </div>

                        <!-- Bottom details -->
                        <div class="z-20 text-left">
                            <p class="text-xs text-blue-400 font-bold tracking-widest uppercase">Editor's Choice</p>
                            <h3 class="text-2xl font-bold text-white mt-1">Smartphones & Wearables</h3>
                            <p class="text-sm text-slate-300 mt-1">Up to 30% Off on selected audio gears and smartwatches.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Value Propositions -->
    <div class="bg-white dark:bg-slate-900 border-y border-gray-100 dark:border-slate-800/60 py-12">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex gap-4 items-start">
                    <div class="p-3 bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 rounded-xl">
                        🚚
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 dark:text-white">Free Express Shipping</h4>
                        <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">On all orders over $150. Packaged securely and shipped fast.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="p-3 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 rounded-xl">
                        🔒
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 dark:text-white">Secure Encrypted Checkout</h4>
                        <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Your data is safe with Stripe and PayPal payments.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="p-3 bg-cyan-50 dark:bg-cyan-950/40 text-cyan-600 dark:text-cyan-400 rounded-xl">
                        🔄
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 dark:text-white">30-Day Easy Returns</h4>
                        <p class="text-sm text-gray-500 dark:text-slate-400 mt-1">Not satisfied? Return any product easily within 30 days.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Browse Categories Section -->
    <div class="py-20 bg-slate-50 dark:bg-slate-950/30">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 dark:text-blue-400 font-bold uppercase tracking-widest">Our Collections</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight">
                    Browse Categories
                </h2>
                <div class="w-16 h-1 bg-blue-600 mx-auto rounded"></div>
                <p class="text-gray-500 dark:text-slate-400 text-sm">
                    Discover premium gadgets grouped by category to fit your daily style and performance needs.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($categories as $category)
                    <a wire:navigate href="/products?selected_categories[0]={{ $category->id }}" class="group flex flex-col bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift text-center" wire:key="category-{{ $category->id }}">
                        <div class="w-16 h-16 bg-blue-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow">
                            @if($category->image)
                                <img class="h-10 w-10 object-contain rounded-lg" src="{{ url('storage', $category->image) }}" alt="{{ $category->name }}">
                            @else
                                <span class="text-2xl">📦</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-sm">
                            {{ $category->name }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Browse Popular Brands Section -->
    <div class="py-20 bg-white dark:bg-slate-900">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                <span class="text-xs text-blue-600 dark:text-blue-400 font-bold uppercase tracking-widest">Industry Leaders</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight">
                    Browse Popular Brands
                </h2>
                <div class="w-16 h-1 bg-blue-600 mx-auto rounded"></div>
                <p class="text-gray-500 dark:text-slate-400 text-sm">
                    Shop genuine high-quality products directly from leading technology brands.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach ($brands as $brand)
                    <a wire:navigate href="/products?selected_brands[0]={{ $brand->id }}" class="group flex flex-col bg-slate-50 dark:bg-slate-950/20 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift text-center" wire:key="brand-{{ $brand->id }}">
                        <div class="w-16 h-16 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow">
                            @if($brand->image)
                                <img class="h-10 w-10 object-contain rounded-full" src="{{ url('storage', $brand->image) }}" alt="{{ $brand->name }}">
                            @else
                                <span class="text-xl font-bold uppercase text-gray-500 group-hover:text-white">{{ substr($brand->name, 0, 2) }}</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-sm">
                            {{ $brand->name }}
                        </h3>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
