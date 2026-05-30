<header class="sticky top-0 z-50 w-full bg-white/90 dark:bg-slate-950/90 backdrop-blur-md border-b border-slate-200/40 dark:border-slate-800/40 shadow-sm transition-all duration-300">
    <nav class="max-w-[85rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-3" aria-label="Global">
        <div class="flex items-center justify-between gap-4">
            <!-- Logo -->
            <a wire:navigate class="flex items-center gap-2.5 text-2xl font-black tracking-tight text-slate-900 dark:text-white shrink-0" href="/">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-md shadow-blue-500/25">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                    </svg>
                </div>
                <span class="bg-gradient-to-r from-slate-950 via-slate-900 to-slate-850 dark:from-white dark:to-slate-200 bg-clip-text text-transparent font-extrabold">Byte<span class="text-blue-600 dark:text-blue-400">Webster</span></span>
            </a>

            <!-- Navigation Links & Categories Mega Menu -->
            <div class="hidden lg:flex items-center gap-7 text-sm font-semibold text-slate-650 dark:text-slate-350">
                <a wire:navigate href="/" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->routeIs('index') ? 'text-blue-600 dark:text-blue-400' : '' }}">Home</a>
                
                <!-- Mega Menu Trigger -->
                <div class="hs-dropdown [--strategy:static] sm:[--strategy:fixed] [--adaptive:none] py-2">
                    <button id="hs-mega-menu-trigger" type="button" class="flex items-center gap-1.5 hover:text-blue-600 dark:hover:text-blue-400 transition-colors font-semibold text-sm">
                        Categories
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                        </svg>
                    </button>
                    
                    <div class="hs-dropdown-menu transition-[opacity,margin] duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 hidden z-50 w-full sm:w-[480px] bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-2xl rounded-2xl p-4 top-full sm:top-14 mt-2">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-2 mb-2">Departments</h4>
                                <div class="space-y-1">
                                    <a wire:navigate href="/products?selected_categories[0]=1" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <i class="bi bi-smartphone text-lg text-blue-600"></i>
                                        <div>
                                            <p class="text-xs font-bold text-slate-850 dark:text-white">Smartphones</p>
                                            <p class="text-[10px] text-slate-500">iOS & Android</p>
                                        </div>
                                    </a>
                                    <a wire:navigate href="/products?selected_categories[0]=2" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <i class="bi bi-laptop text-lg text-blue-600"></i>
                                        <div>
                                            <p class="text-xs font-bold text-slate-850 dark:text-white">Laptops & PCs</p>
                                            <p class="text-[10px] text-slate-500">Macbooks & Windows</p>
                                        </div>
                                    </a>
                                    <a wire:navigate href="/products?selected_categories[0]=3" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <i class="bi bi-headphones text-lg text-blue-600"></i>
                                        <div>
                                            <p class="text-xs font-bold text-slate-850 dark:text-white">Audio & Sound</p>
                                            <p class="text-[10px] text-slate-500">Noise Canceling</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest px-2 mb-2">Wearables & TV</h4>
                                <div class="space-y-1">
                                    <a wire:navigate href="/products?selected_categories[0]=4" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <i class="bi bi-watch text-lg text-blue-600"></i>
                                        <div>
                                            <p class="text-xs font-bold text-slate-850 dark:text-white">Smartwatches</p>
                                            <p class="text-[10px] text-slate-500">Fitness & LTE</p>
                                        </div>
                                    </a>
                                    <a wire:navigate href="/products?selected_categories[0]=5" class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                        <i class="bi bi-tv text-lg text-blue-600"></i>
                                        <div>
                                            <p class="text-xs font-bold text-slate-850 dark:text-white">Televisions</p>
                                            <p class="text-[10px] text-slate-500">4K OLED & Smart TV</p>
                                        </div>
                                    </a>
                                    <a wire:navigate href="/products" class="flex items-center justify-between p-2 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 transition font-bold text-xs mt-2">
                                        <span>View All Departments</span>
                                        <span>→</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a wire:navigate href="/products" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->routeIs('all-products') ? 'text-blue-600 dark:text-blue-400' : '' }}">Products</a>
            </div>

            <!-- AI-Powered Search Bar in Center -->
            <div class="flex-1 max-w-md mx-4 hidden md:block">
                <form action="/products" method="GET" class="relative">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Ask AI or search products..." class="w-full py-2.5 pl-10 pr-16 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs focus:bg-white dark:focus:bg-slate-950 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 dark:text-white transition duration-200" value="{{ request('search') }}">
                        <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-3.5">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-1.5 gap-1">
                            <div class="inline-flex items-center gap-1 py-1 px-2 rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold text-[9px] shadow-sm select-none">
                                <span>⚡ AI Search</span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Actions Icons (Wishlist, Cart, Bell, User Profile) -->
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <!-- Notifications Bell -->
                <button type="button" class="relative p-2.5 text-slate-650 hover:text-blue-600 dark:text-slate-350 dark:hover:text-blue-400 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-900 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a9.049 9.049 0 01-5.185-2.813 9.049 9.049 0 01-2.813-5.185M9 17h6m-3-11V3m0 0l-3 3m3-3l3 3M4 10a8 8 0 1116 0c0 4.135 3 6 3 6H1s3-1.865 3-6z" />
                    </svg>
                    <span class="absolute top-2 right-2 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                </button>

                <!-- Cart Icon Desktop -->
                <a wire:navigate class="relative p-2.5 text-slate-650 hover:text-blue-600 dark:text-slate-350 dark:hover:text-blue-400 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-900 transition" href="{{ route('cart-products') }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
                    </svg>
                    <span class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-[9px] font-bold text-white ring-2 ring-white dark:ring-slate-950">{{ $total_count }}</span>
                </a>

                <!-- User Profile / Auth Actions -->
                @guest
                    <div class="flex items-center gap-2 pl-2 border-l border-slate-200 dark:border-slate-800">
                        <a wire:navigate class="py-2 px-4 inline-flex items-center gap-x-1.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-slate-750 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition" href="{{ route('login') }}">
                            Log in
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="hs-dropdown relative inline-flex [--strategy:static] md:[--strategy:fixed] [--adaptive:none] md:[--trigger:hover] pl-2 border-l border-slate-200 dark:border-slate-800">
                        <button id="hs-dropdown-avatar" type="button" class="hs-dropdown-toggle flex items-center gap-2 text-slate-700 dark:text-slate-350 hover:text-blue-600 font-semibold text-sm transition">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-bold text-xs uppercase shadow-sm">
                                {{ substr(auth()->user()->name, 0, 2) }}
                            </div>
                            <span class="hidden sm:inline font-bold">{{ auth()->user()->name }}</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </button>

                        <div class="hs-dropdown-menu transition-[opacity,margin] duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 md:w-52 hidden z-50 bg-white dark:bg-slate-900 md:shadow-2xl rounded-2xl p-2 border border-slate-100 dark:border-slate-800 before:absolute top-full before:-top-5 before:start-0 before:w-full before:h-5 mt-2">
                            <a class="flex items-center gap-x-3 py-2.5 px-3.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-350 hover:bg-slate-50 dark:hover:bg-slate-800 transition" href="{{ route('my-orders') }}">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                My Orders
                            </a>
                            
                            @if(auth()->user()->email === 'test@example.com' || (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()))
                            <a class="flex items-center gap-x-3 py-2.5 px-3.5 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-350 hover:bg-slate-50 dark:hover:bg-slate-800 transition" href="/admin">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Admin Panel
                            </a>
                            @endif

                            <hr class="my-1.5 border-slate-100 dark:border-slate-800">

                            <button type="button" wire:click="logout" class="flex w-full items-center gap-x-3 py-2.5 px-3.5 rounded-xl text-xs font-semibold text-red-650 hover:bg-red-50 dark:hover:bg-red-950/20 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path>
                                </svg>
                                Logout
                            </button>
                        </div>
                    </div>
                @endauth
                
                <!-- Mobile Toggle button -->
                <button type="button" class="hs-collapse-toggle flex justify-center items-center w-9 h-9 text-sm font-semibold rounded-xl border border-slate-200 text-slate-850 hover:bg-slate-50 dark:text-white dark:border-slate-800 dark:hover:bg-slate-900 transition md:hidden" data-hs-collapse="#navbar-collapse" aria-controls="navbar-collapse" aria-label="Toggle navigation">
                    <svg class="hs-collapse-open:hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="3" x2="21" y1="6" y2="6" />
                        <line x1="3" x2="21" y1="12" y2="12" />
                        <line x1="3" x2="21" y1="18" y2="18" />
                    </svg>
                    <svg class="hs-collapse-open:block hidden w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path d="M18 6 6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="navbar-collapse" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow lg:hidden">
            <div class="flex flex-col gap-4 mt-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                <!-- Mobile Search -->
                <form action="/products" method="GET" class="relative w-full">
                    <input type="text" name="search" placeholder="Search products..." class="w-full py-2 pl-10 pr-4 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:outline-none dark:text-white" value="{{ request('search') }}">
                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-3.5">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </form>

                <div class="flex flex-col gap-2">
                    <a wire:navigate class="font-bold text-sm py-2.5 px-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200" href="/">Home</a>
                    <a wire:navigate class="font-bold text-sm py-2.5 px-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200" href="/categories">Categories</a>
                    <a wire:navigate class="font-bold text-sm py-2.5 px-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200" href="/products">Products</a>
                </div>
            </div>
        </div>
    </nav>
</header>