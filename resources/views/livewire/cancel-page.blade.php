<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto text-left">
    <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 sm:p-10 shadow-sm max-w-2xl mx-auto text-center space-y-6">
        
        <!-- Warning Icon -->
        <div class="w-20 h-20 bg-red-50 dark:bg-red-950/30 text-red-500 dark:text-red-400 rounded-full flex items-center justify-center mx-auto text-4xl shadow-sm border border-red-100 dark:border-red-900/50">
            ⚠
        </div>
        
        <div class="space-y-2">
            <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">Payment Cancelled</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400 max-w-sm mx-auto">Your payment was cancelled or could not be processed. No funds have been charged from your account.</p>
        </div>

        <!-- Actions -->
        <div class="flex flex-wrap justify-center gap-4 pt-4 border-t border-gray-100 dark:border-slate-800/80">
            <a wire:navigate href="/cart" class="py-2.5 px-5 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 dark:border-slate-700 dark:text-gray-300 dark:hover:bg-slate-800 transition">
                Return to Cart
            </a>
            <a wire:navigate href="/products" class="py-2.5 px-5 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                Continue Shopping
            </a>
        </div>
    </div>
</div>