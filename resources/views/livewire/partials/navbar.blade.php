<header class="sticky top-0 z-50 w-full transition-all duration-300 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-gray-200/50 dark:border-slate-800/50">
    <nav class="max-w-[85rem] w-full mx-auto px-4 sm:px-6 lg:px-8 py-3.5" aria-label="Global">
      <div class="flex items-center justify-between">
        <!-- Logo -->
        <a wire:navigate class="flex items-center gap-2 text-2xl font-extrabold tracking-tight text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400" href="/">
          <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path>
          </svg>
          <span>ByteWebster</span>
        </a>

        <!-- Mobile Toggle & Actions -->
        <div class="flex items-center gap-4 md:hidden">
          <!-- Cart Icon Mobile -->
          <a wire:navigate class="relative p-2 text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition" href="{{ route('cart-products') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
            </svg>
            <span class="absolute top-0.5 right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white ring-2 ring-white dark:ring-slate-900">{{ $total_count }}</span>
          </a>

          <!-- Menu Button -->
          <button type="button" class="hs-collapse-toggle flex justify-center items-center w-9 h-9 text-sm font-semibold rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-50 dark:text-white dark:border-gray-700 dark:hover:bg-slate-800 transition" data-hs-collapse="#navbar-collapse" aria-controls="navbar-collapse" aria-label="Toggle navigation">
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

        <!-- Navigation Links -->
        <div id="navbar-collapse" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block">
          <div class="flex flex-col md:flex-row md:items-center md:justify-end gap-5 mt-5 md:mt-0 md:ps-7">
            
            <a wire:navigate class="font-medium text-sm transition {{ request()->routeIs('index') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400' }} py-2" href="{{ route('index') }}">Home</a>
            
            <a wire:navigate class="font-medium text-sm transition {{ request()->routeIs('product-categories') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400' }} py-2" href="{{ route('product-categories') }}">Categories</a>
            
            <a wire:navigate class="font-medium text-sm transition {{ request()->routeIs('all-products') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400' }} py-2" href="{{ route('all-products') }}">Products</a>

            <!-- Search Form in Navbar -->
            <form action="{{ route('all-products') }}" method="GET" class="relative max-w-xs w-full">
              <div class="relative">
                <input type="text" name="search" placeholder="Search products..." class="py-1.5 pl-9 pr-4 block w-full bg-gray-50 border border-gray-200/80 rounded-lg text-xs focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-gray-400" value="{{ request('search') }}">
                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-3">
                  <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                  </svg>
                </div>
              </div>
            </form>

            <!-- Cart Icon Desktop -->
            <a wire:navigate class="relative hidden md:flex items-center gap-1.5 p-2 text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition" href="{{ route('cart-products') }}">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.119-1.243l1.263-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z"></path>
              </svg>
              <span class="absolute top-0 right-0 flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white ring-2 ring-white dark:ring-slate-900">{{ $total_count }}</span>
            </a>

            <!-- Auth Buttons -->
            @guest
              <div class="flex items-center gap-3 pt-3 md:pt-0 border-t border-gray-100 md:border-t-0 dark:border-slate-800">
                <a wire:navigate class="py-1.5 px-3.5 inline-flex items-center gap-x-2 text-xs font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 transition" href="{{ route('login') }}">
                  Log in
                </a>
                <a wire:navigate class="py-1.5 px-3.5 inline-flex items-center gap-x-2 text-xs font-semibold rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 dark:border-slate-700 dark:text-gray-300 dark:hover:bg-slate-800 transition" href="{{ route('register') }}">
                  Register
                </a>
              </div>
            @endguest

            @auth
              <div class="hs-dropdown relative inline-flex [--strategy:static] md:[--strategy:fixed] [--adaptive:none] md:[--trigger:hover] py-2 md:py-0 border-t border-gray-100 md:border-t-0 dark:border-slate-800">
                <button id="hs-dropdown-avatar" type="button" class="hs-dropdown-toggle flex items-center gap-2 w-full text-gray-600 hover:text-blue-600 font-semibold text-sm dark:text-gray-300 dark:hover:text-blue-400 transition">
                  <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold text-xs uppercase shadow">
                    {{ substr(auth()->user()->name, 0, 2) }}
                  </div>
                  <span>{{ auth()->user()->name }}</span>
                  <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                  </svg>
                </button>

                <div class="hs-dropdown-menu transition-[opacity,margin] duration-[0.1ms] md:duration-[150ms] hs-dropdown-open:opacity-100 opacity-0 md:w-48 hidden z-30 bg-white md:shadow-lg rounded-xl p-1.5 dark:bg-slate-800 md:dark:border dark:border-slate-700 border border-gray-100 before:absolute top-full before:-top-5 before:start-0 before:w-full before:h-5">
                  <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-xs text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-slate-700 transition" href="{{ route('my-orders') }}">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    My Orders
                  </a>
                  
                  <a class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-xs text-gray-700 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-slate-700 transition" href="/admin">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Admin Panel
                  </a>

                  <hr class="my-1 border-gray-100 dark:border-slate-700">

                  <button type="button" wire:click="logout" class="flex w-full items-center gap-x-3 py-2 px-3 rounded-lg text-xs text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"></path>
                    </svg>
                    Logout
                  </button>
                </div>
              </div>
            @endauth

          </div>
        </div>
      </div>
    </nav>
</header>