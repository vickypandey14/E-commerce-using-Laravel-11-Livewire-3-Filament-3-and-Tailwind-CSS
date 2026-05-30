<footer class="bg-white text-slate-600 w-full border-t border-slate-200/80 shadow-inner">
    <div class="max-w-[85rem] py-16 px-4 sm:px-6 lg:px-8 mx-auto">
        <!-- Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-12">
            <!-- Brand Column -->
            <div class="col-span-full lg:col-span-2 space-y-6 text-left">
                <a wire:navigate class="flex items-center gap-2.5 text-2xl font-black tracking-tight text-slate-900" href="/">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path>
                        </svg>
                    </div>
                    <span class="font-extrabold">Byte<span class="text-blue-600">Webster</span></span>
                </a>
                <p class="text-sm text-slate-500 max-w-sm leading-relaxed">
                    The premium electronics marketplace. Authorized vendor of genuine laptops, smartphones, sound devices, and cameras with official manufacturer coverage.
                </p>

                <!-- App Download Buttons Mockups -->
                <div class="flex flex-wrap gap-3 pt-2">
                    <!-- App Store Button -->
                    <a href="#" class="inline-flex items-center gap-2.5 bg-slate-950 border border-slate-900 hover:bg-slate-900/90 px-3.5 py-1.5 rounded-xl shadow-md transition">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 4.17c.66-.81 1.11-1.93.99-3.06-1 .04-2.22.67-2.94 1.51-.64.74-1.2 1.88-1.05 3 .99-.02 2.34-.64 3-1.45z"/>
                        </svg>
                        <div class="text-left leading-none">
                            <p class="text-[8px] text-slate-500 uppercase tracking-widest">Download on the</p>
                            <p class="text-xs font-bold text-white mt-0.5">App Store</p>
                        </div>
                    </a>

                    <!-- Google Play Button -->
                    <a href="#" class="inline-flex items-center gap-2.5 bg-slate-950 border border-slate-900 hover:bg-slate-900/90 px-3.5 py-1.5 rounded-xl shadow-md transition">
                        <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M5 3.25A1.75 1.75 0 0 0 3.25 5v14A1.75 1.75 0 0 0 5 20.75h14A1.75 1.75 0 0 0 20.75 19V5A1.75 1.75 0 0 0 19 3.25H5zm1.5 3l4.5 4.5-4.5 4.5V6.25zm1 10.3l3.5-3.5 1.75 1.75-5.25 1.75zm6.5-5.25l3.5-3.5v7l-3.5-3.5zm-1.75-1.75l3.5-3.5H9.25l1.75 1.75z"/>
                        </svg>
                        <div class="text-left leading-none">
                            <p class="text-[8px] text-slate-500 uppercase tracking-widest">Get it on</p>
                            <p class="text-xs font-bold text-white mt-0.5">Google Play</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Product / Shop Link Column -->
            <div class="col-span-1 text-left space-y-4">
                <h4 class="font-bold text-sm text-slate-800 uppercase tracking-wider">Shop Tech</h4>
                <div class="grid space-y-2.5 text-xs text-slate-500">
                    <p><a class="hover:text-blue-600 transition" href="/categories">All Categories</a></p>
                    <p><a class="hover:text-blue-600 transition" href="/products">All Products</a></p>
                    <p><a class="hover:text-blue-600 transition" href="/products?selected_categories[0]=1">Smartphones</a></p>
                    <p><a class="hover:text-blue-600 transition" href="/products?selected_categories[0]=2">Laptops & PCs</a></p>
                </div>
            </div>

            <!-- Company Column -->
            <div class="col-span-1 text-left space-y-4">
                <h4 class="font-bold text-sm text-slate-800 uppercase tracking-wider">Company</h4>
                <div class="grid space-y-2.5 text-xs text-slate-500">
                    <p><a class="hover:text-blue-600 transition" href="#">About Us</a></p>
                    <p><a class="hover:text-blue-600 transition" href="#">Corporate Sales</a></p>
                    <p><a class="hover:text-blue-600 transition" href="#">Partner Network</a></p>
                    <p><a class="hover:text-blue-600 transition" href="#">Careers</a></p>
                </div>
            </div>

            <!-- Support Column -->
            <div class="col-span-1 text-left space-y-4">
                <h4 class="font-bold text-sm text-slate-800 uppercase tracking-wider">Support</h4>
                <div class="grid space-y-2.5 text-xs text-slate-500">
                    <p><a class="hover:text-blue-600 transition" href="#">Contact Support</a></p>
                    <p><a class="hover:text-blue-600 transition" href="#">Track Order</a></p>
                    <p><a class="hover:text-blue-600 transition" href="#">Warranty Info</a></p>
                    <p><a class="hover:text-blue-600 transition" href="#">Return Policy</a></p>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="border-slate-200/80 my-8">

        <!-- Bottom Row -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="text-left space-y-1.5">
                <p class="text-xs text-slate-400">© 2026 ByteWebster Inc. All rights reserved.</p>
                <!-- Security trust badges -->
                <div class="flex flex-wrap items-center gap-4 text-[10px] text-slate-500 font-bold uppercase tracking-wider">
                    <span class="flex items-center gap-1.5"><i class="bi bi-shield-check text-blue-600 text-xs"></i> PCI-DSS Secure</span>
                    <span class="flex items-center gap-1.5"><i class="bi bi-lock-fill text-blue-600 text-xs"></i> SSL 256-Bit Encrypted</span>
                </div>
            </div>

            <!-- Payment Methods Mock SVG Container -->
            <div class="flex flex-wrap gap-2 text-slate-400">
                <!-- Visa -->
                <div class="px-2.5 py-1 bg-slate-50 border border-slate-200 text-[9px] font-bold tracking-widest uppercase">Visa</div>
                <!-- Mastercard -->
                <div class="px-2.5 py-1 bg-slate-50 border border-slate-200 text-[9px] font-bold tracking-widest uppercase">Mastercard</div>
                <!-- Apple Pay -->
                <div class="px-2.5 py-1 bg-slate-50 border border-slate-200 text-[9px] font-bold tracking-widest uppercase">Apple Pay</div>
                <!-- PayPal -->
                <div class="px-2.5 py-1 bg-slate-50 border border-slate-200 text-[9px] font-bold tracking-widest uppercase">PayPal</div>
            </div>

            <!-- Social Links -->
            <div class="flex gap-4">
                <a class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition" href="#">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition" href="#">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                <a class="w-8 h-8 rounded-lg bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-500 hover:text-blue-600 hover:bg-slate-100 transition" href="#">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>