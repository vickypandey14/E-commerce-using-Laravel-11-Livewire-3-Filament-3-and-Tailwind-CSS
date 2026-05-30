<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
        <span class="text-xs text-blue-600 dark:text-blue-400 font-bold uppercase tracking-widest">Collections</span>
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight">
            All Categories
        </h2>
        <div class="w-16 h-1 bg-blue-600 mx-auto rounded"></div>
        <p class="text-gray-500 dark:text-slate-400 text-sm">
            Browse our full catalog of categories. Select any category to view its products.
        </p>
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach ($categories as $category)
            <a class="group flex flex-col bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 shadow-sm rounded-2xl hover:shadow-xl hover:shadow-blue-500/5 transition hover-lift" href="/products?selected_categories[0]={{ $category->id }}" wire:key="cat-card-{{ $category->id }}">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-blue-50 dark:bg-slate-800 rounded-xl flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow">
                                @if($category->image)
                                    <img class="h-10 w-10 object-contain rounded-lg" src="{{ $category->getImageUrl() }}" alt="{{ $category->name }}">
                                @else
                                    <i class="bi bi-box-seam text-2xl text-blue-600 group-hover:text-white transition duration-300"></i>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition text-base">
                                    {{ $category->name }}
                                </h3>
                                <span class="text-xs text-gray-400 dark:text-slate-500">View products →</span>
                            </div>
                        </div>
                        <div class="text-gray-400 group-hover:text-blue-600 transition">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>