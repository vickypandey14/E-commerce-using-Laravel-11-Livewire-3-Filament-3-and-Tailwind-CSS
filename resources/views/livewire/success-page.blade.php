<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto text-left">
    <!-- Breadcrumb -->
    <nav class="flex mb-6 text-xs text-gray-500 dark:text-slate-400 font-medium" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center hover:text-blue-600 dark:hover:text-blue-500">
                    <i class="bi bi-house-door-fill mr-1.5 text-sm"></i>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="bi bi-chevron-right mx-1 text-gray-400 dark:text-slate-650 text-[10px]"></i>
                    <a href="/products" class="hover:text-blue-600 dark:hover:text-blue-500">Products</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="bi bi-chevron-right mx-1 text-gray-400 dark:text-slate-650 text-[10px]"></i>
                    <span class="text-gray-800 dark:text-white font-semibold">Order Success</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 sm:p-10 shadow-sm max-w-4xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="text-center space-y-4">
            <div class="w-20 h-20 bg-green-50 dark:bg-green-950/30 text-green-500 dark:text-green-400 rounded-full flex items-center justify-center mx-auto text-4xl shadow-sm border border-green-100 dark:border-green-900/50">
                ✓
            </div>
            <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white tracking-tight">Order Placed Successfully!</h1>
            <p class="text-sm text-gray-500 dark:text-slate-400">Thank you for your purchase. We have received your order and are processing it.</p>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 py-6 border-y border-gray-100 dark:border-slate-800/80">
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase">Order Number</span>
                <span class="block font-bold text-sm text-gray-800 dark:text-white mt-1">#{{ $order->id }}</span>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase">Order Date</span>
                <span class="block font-bold text-sm text-gray-800 dark:text-white mt-1">{{ $order->created_at->format('M d, Y') }}</span>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase">Total Amount</span>
                <span class="block font-extrabold text-sm text-blue-600 dark:text-blue-400 mt-1">{{ Number::currency($order->grand_total, 'INR') }}</span>
            </div>
            <div>
                <span class="block text-xs font-bold text-gray-400 uppercase">Payment Method</span>
                <span class="block font-bold text-sm text-gray-800 dark:text-white mt-1 uppercase">{{ $order->payment_method === 'cod' ? 'Cash on Delivery' : $order->payment_method }}</span>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Order Details -->
            <div class="space-y-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Order Summary</h2>
                <div class="bg-gray-50 dark:bg-slate-800/40 rounded-2xl p-5 border border-gray-100 dark:border-slate-800/50 space-y-4">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-slate-400">
                        <span>Subtotal</span>
                        <span class="font-semibold text-gray-800 dark:text-white">{{ Number::currency($order->grand_total - $order->shipping_amount, 'INR') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-600 dark:text-slate-400">
                        <span>Shipping</span>
                        <span class="font-semibold text-gray-800 dark:text-white">
                            {{ $order->shipping_amount > 0 ? Number::currency($order->shipping_amount, 'INR') : 'Free' }}
                        </span>
                    </div>
                    <div class="border-t border-gray-200 dark:border-slate-700/60 pt-3 flex justify-between items-center text-base font-bold">
                        <span class="text-gray-800 dark:text-white">Total Paid</span>
                        <span class="text-lg text-blue-600 dark:text-blue-400 font-extrabold">{{ Number::currency($order->grand_total, 'INR') }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping / Delivery Details -->
            <div class="space-y-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Shipping Address</h2>
                <div class="bg-gray-50 dark:bg-slate-800/40 rounded-2xl p-5 border border-gray-100 dark:border-slate-800/50 space-y-2 text-sm text-gray-600 dark:text-slate-400">
                    <p class="font-bold text-gray-800 dark:text-white text-base mb-1">
                        {{ $order->address->first_name }} {{ $order->address->last_name }}
                    </p>
                    <p>{{ $order->address->street_address }}</p>
                    <p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}</p>
                    <p class="pt-2 font-medium">📞 Phone: {{ $order->address->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-wrap gap-4 pt-4 border-t border-gray-100 dark:border-slate-800/80">
            <a wire:navigate href="/products" class="py-2.5 px-5 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 dark:border-slate-700 dark:text-gray-300 dark:hover:bg-slate-800 transition">
                Continue Shopping
            </a>
            <a wire:navigate href="/my-orders" class="py-2.5 px-5 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                View My Orders
            </a>
        </div>
    </div>
</div>