<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="max-w-2xl mx-auto mb-10 text-left">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 dark:text-white sm:text-4xl">Checkout</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">Enter your shipping details and select your payment method.</p>
    </div>

    <form wire:submit.prevent="placeOrder" class="flex flex-col lg:flex-row gap-8">
        <!-- Billing / Shipping Form -->
        <div class="w-full lg:w-3/5 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 text-left">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white pb-3 border-b border-gray-100 dark:border-slate-800/80">Shipping Details</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2" for="first_name">First Name</label>
                        <input class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white" id="first_name" wire:model="first_name" type="text" required>
                        @error('first_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2" for="last_name">Last Name</label>
                        <input class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white" id="last_name" wire:model="last_name" type="text" required>
                        @error('last_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2" for="phone">Phone Number</label>
                    <input class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white" id="phone" wire:model="phone" type="text" required>
                    @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2" for="street_address">Street Address</label>
                    <input class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white" id="street_address" wire:model="street_address" type="text" required>
                    @error('street_address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2" for="city">City</label>
                        <input class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white" id="city" wire:model="city" type="text" required>
                        @error('city') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2" for="state">State</label>
                        <input class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white" id="state" wire:model="state" type="text" required>
                        @error('state') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-2" for="zip_code">ZIP Code</label>
                        <input class="w-full py-2.5 px-4 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-slate-800 dark:border-slate-700 dark:text-white" id="zip_code" wire:model="zip_code" type="text" required>
                        @error('zip_code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6 text-left">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white pb-3 border-b border-gray-100 dark:border-slate-800/80">Payment Method</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Cash on Delivery -->
                    <label for="pay-cod" class="relative block bg-gray-50 dark:bg-slate-800/40 border border-gray-200 dark:border-slate-700 rounded-2xl p-5 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-800 transition select-none">
                        <div class="flex items-center gap-3">
                            <input type="radio" id="pay-cod" wire:model="payment_method" value="cod" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div>
                                <span class="block font-bold text-gray-800 dark:text-white text-sm">Cash on Delivery</span>
                                <span class="block text-xs text-gray-400 mt-0.5">Pay with cash upon delivery.</span>
                            </div>
                        </div>
                    </label>

                    <!-- Stripe -->
                    <label for="pay-stripe" class="relative block bg-gray-50 dark:bg-slate-800/40 border border-gray-200 dark:border-slate-700 rounded-2xl p-5 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-800 transition select-none">
                        <div class="flex items-center gap-3">
                            <input type="radio" id="pay-stripe" wire:model="payment_method" value="stripe" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <div>
                                <span class="block font-bold text-gray-800 dark:text-white text-sm">Card Payment (Stripe)</span>
                                <span class="block text-xs text-gray-400 mt-0.5">Pay securely via Credit/Debit card.</span>
                            </div>
                        </div>
                    </label>
                </div>
                @error('payment_method') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Sidebar Summary -->
        <div class="w-full lg:w-2/5 space-y-6">
            <!-- Basket Summary -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 shadow-sm space-y-6 text-left">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-slate-800/80 pb-3">Order Items</h2>
                
                <ul class="divide-y divide-gray-100 dark:divide-slate-800/60 max-h-96 overflow-y-auto pr-2">
                    @foreach ($cart_items as $item)
                        <li class="py-3.5 flex items-center justify-between gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-slate-50 dark:bg-slate-950/20 border border-gray-100 dark:border-slate-800/60 rounded-lg overflow-hidden flex items-center justify-center p-1 flex-shrink-0">
                                    @if($item['image'])
                                        <img class="object-contain w-full h-full" src="{{ url('storage', $item['image']) }}" alt="{{ $item['name'] }}">
                                    @else
                                        <img class="object-contain w-full h-full" src="https://placehold.co/150x150/6366f1/ffffff?text={{ urlencode($item['name']) }}" alt="{{ $item['name'] }}">
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <span class="block font-bold text-gray-800 dark:text-gray-200 text-xs truncate max-w-[150px] sm:max-w-[200px]">{{ $item['name'] }}</span>
                                    <span class="block text-[10px] text-gray-400 mt-0.5">Qty: {{ $item['quantity'] }}</span>
                                </div>
                            </div>
                            <span class="font-bold text-xs text-gray-700 dark:text-slate-300">
                                {{ Number::currency($item['total_amount'], 'INR') }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Price Summary -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 shadow-sm space-y-6 text-left">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-slate-800/80 pb-3">Price Summary</h2>
                
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
                    <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                        <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                        <span wire:loading wire:target="placeOrder">Processing Order...</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>