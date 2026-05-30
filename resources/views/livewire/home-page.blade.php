<div class="w-full">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-gradient-to-tr from-slate-50 via-blue-50 to-indigo-50/50 py-16 lg:py-24 border-b border-gray-100">
        <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-blue-400/20 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-indigo-400/10 rounded-full blur-3xl -z-10"></div>

        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 text-left">
                    <div class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 border border-blue-200">
                        🔥 Top Deals of the Week
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-tight">
                        Shop Real Electronics at <span class="text-blue-600">ByteWebster</span>
                    </h1>
                    <p class="text-lg text-slate-600 max-w-lg">
                        Get the best deals on smartphones, laptops, audio gear, smartwatches, and televisions. Real products from top brands with free express shipping.
                    </p>
                    
                    <!-- Call to Action Buttons -->
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a wire:navigate href="/products" class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                            Browse Products
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path>
                            </svg>
                        </a>
                        <a wire:navigate href="/categories" class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-xl border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition">
                            Browse Categories
                        </a>
                    </div>

                    <!-- Trust Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-6 border-t border-slate-200">
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-blue-600">100%</p>
                            <p class="text-xs text-slate-500 mt-1">Genuine Products</p>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-indigo-600">24/7</p>
                            <p class="text-xs text-slate-500 mt-1">Customer Service</p>
                        </div>
                        <div>
                            <p class="text-2xl sm:text-3xl font-extrabold text-cyan-600">Free</p>
                            <p class="text-xs text-slate-500 mt-1">Express Delivery</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Interactive Image Banner (Light Themed) -->
                <div class="relative flex justify-center items-center">
                    <div class="relative w-full max-w-[450px] aspect-square rounded-3xl overflow-hidden shadow-xl border border-gray-200/80 bg-white p-6 flex flex-col justify-between hover-scale">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-100 via-transparent to-transparent z-10"></div>
                        
                        <!-- Top details -->
                        <div class="flex justify-between items-start z-20">
                            <span class="bg-blue-600 text-white font-bold text-xs px-2.5 py-1 rounded-full uppercase tracking-wider">Top Brands Only</span>
                            <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-gray-700 shadow-sm border border-gray-100">
                                🛒
                            </div>
                        </div>

                        <!-- Mid Product Card Mockup -->
                        <div class="my-auto z-20 space-y-2 flex flex-col items-center">
                            <div class="w-44 h-44 bg-gradient-to-tr from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center text-white text-6xl shadow-lg shadow-blue-500/10 transform rotate-3 hover:rotate-0 transition duration-300">
                                📱
                            </div>
                        </div>

                        <!-- Bottom details -->
                        <div class="z-20 text-left">
                            <p class="text-xs text-blue-600 font-bold tracking-widest uppercase">Popular Choices</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">Smartphones & Laptops</h3>
                            <p class="text-sm text-slate-600 mt-1">Find products from Apple, Samsung, Dell, and other top brands.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Value Propositions -->
    <div class="bg-white border-b border-gray-100 py-12">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex gap-4 items-start">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                        🚚
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Free Express Delivery</h4>
                        <p class="text-sm text-slate-500 mt-1">Enjoy free express shipping on orders. Shipped safely to your door.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                        🔒
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Safe Checkout</h4>
                        <p class="text-sm text-slate-500 mt-1">Your payments are fully secure. We support cash on delivery and cards.</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start">
                    <div class="p-3 bg-cyan-50 text-cyan-600 rounded-xl">
                        🔄
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">Easy Returns</h4>
                        <p class="text-sm text-slate-500 mt-1">Not what you wanted? Return items easily within 30 days of purchase.</p>
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
                            @if($category->image)
                                <img class="h-10 w-10 object-contain rounded-lg" src="{{ url('storage', $category->image) }}" alt="{{ $category->name }}">
                            @else
                                <span class="text-2xl">📦</span>
                            @endif
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
                            @if($brand->image)
                                <img class="h-10 w-10 object-contain rounded-full" src="{{ url('storage', $brand->image) }}" alt="{{ $brand->name }}">
                            @else
                                <span class="text-sm font-extrabold uppercase text-gray-500 group-hover:text-white">{{ substr($brand->name, 0, 2) }}</span>
                            @endif
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
