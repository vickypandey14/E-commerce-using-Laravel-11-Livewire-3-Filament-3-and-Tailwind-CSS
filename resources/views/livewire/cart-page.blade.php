<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-2xl mx-auto mb-10 text-left">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 dark:text-white sm:text-4xl">Shopping Cart</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">Manage your selected products and proceed to checkout.</p>
    </div>

    @if(empty($cart_items))
        <!-- Empty Cart State -->
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-16 text-center shadow-sm max-w-3xl mx-auto">
            <span class="text-6xl">🛒</span>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mt-6">Your Cart is Empty</h3>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-2 max-w-sm mx-auto">Looks like you haven't added any products to your cart yet. Let's find some gadgets!</p>
            <div class="mt-8">
                <a wire:navigate href="/products" class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                    Continue Shopping
                </a>
            </div>
        </div>
    @else
        <!-- Cart Layout -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items List -->
            <div class="w-full lg:w-3/4 space-y-4">
                <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl overflow-hidden shadow-sm">
                    <div class="p-6 overflow-x-auto">
                        <table class="w-full min-w-[600px] text-left border-collapse">
                            <thead>
                                <tr class="border-b border-gray-100 dark:border-slate-800/80 pb-4 text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                                    <th class="py-3">Product</th>
                                    <th class="py-3">Price</th>
                                    <th class="py-3">Quantity</th>
                                    <th class="py-3 text-right">Total</th>
                                    <th class="py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-slate-800/50">
                                @foreach ($cart_items as $item)
                                    <tr class="align-middle" wire:key="cart-item-{{ $item['product_id'] }}">
                                        <td class="py-4 pr-4">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-16 h-16 bg-slate-50 dark:bg-slate-950/20 border border-gray-105 dark:border-slate-800/60 rounded-xl overflow-hidden flex items-center justify-center p-2 flex-shrink-0">
                                                    @if($item['image'])
                                                        <img class="object-contain w-full h-full" src="{{ (str_starts_with($item['image'], 'http://') || str_starts_with($item['image'], 'https://')) ? $item['image'] : url('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                                                    @else
                                                        <img class="object-contain w-full h-full" src="https://placehold.co/150x150/6366f1/ffffff?text={{ urlencode($item['name']) }}" alt="{{ $item['name'] }}">
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="font-bold text-gray-800 dark:text-gray-200 text-sm line-clamp-2 leading-tight">{{ $item['name'] }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 text-sm font-semibold text-gray-700 dark:text-slate-300">
                                            {{ Number::currency($item['unit_amount'], 'INR') }}
                                        </td>
                                        <td class="py-4">
                                            <div class="flex items-center w-28 bg-gray-50 dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg overflow-hidden">
                                                <button type="button" wire:click="decrementQty({{ $item['product_id'] }})" class="p-1.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-slate-700/50 transition w-8 flex items-center justify-center font-bold">
                                                    -
                                                </button>
                                                <span class="flex-1 text-center font-bold text-xs text-gray-800 dark:text-white">
                                                    {{ $item['quantity'] }}
                                                </span>
                                                <button type="button" wire:click="incrementQty({{ $item['product_id'] }})" class="p-1.5 text-gray-500 hover:bg-gray-100 dark:hover:bg-slate-700/50 transition w-8 flex items-center justify-center font-bold">
                                                    +
                                                </button>
                                            </div>
                                        </td>
                                        <td class="py-4 text-right font-extrabold text-blue-600 dark:text-blue-400 text-sm">
                                            {{ Number::currency($item['total_amount'], 'INR') }}
                                        </td>
                                        <td class="py-4 text-center">
                                            <button type="button" wire:click="removeItem({{ $item['product_id'] }})" class="p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 rounded-xl transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary Sidebar -->
            <div class="w-full lg:w-1/4">
                <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 shadow-sm space-y-6 text-left">
                    <h2 class="text-lg font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-slate-800/80 pb-3">Order Summary</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm text-gray-600 dark:text-slate-400">
                            <span>Subtotal</span>
                            <span class="font-semibold text-gray-800 dark:text-white">{{ Number::currency($grand_total, 'INR') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-slate-400">
                            <span>Shipping</span>
                            <span class="text-green-600 font-semibold">Free</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-slate-800/80 pt-4 flex justify-between items-center">
                        <span class="font-bold text-gray-800 dark:text-white">Total</span>
                        <span class="text-xl font-extrabold text-blue-600 dark:text-blue-400">
                            {{ Number::currency($grand_total, 'INR') }}
                        </span>
                    </div>

                    <div class="pt-2">
                        <a wire:navigate href="/checkout" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>