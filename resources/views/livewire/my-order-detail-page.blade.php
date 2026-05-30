<div class="w-full max-w-[85rem] py-12 px-4 sm:px-6 lg:px-8 mx-auto text-left">
    <div class="max-w-2xl mx-auto mb-10">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 dark:text-white sm:text-4xl">Order Details</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">Detailed summary of Order #{{ $order->id }}.</p>
    </div>

    <!-- Quick Info Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
            <span class="block text-xs font-bold text-gray-400 uppercase">Customer</span>
            <span class="block font-bold text-sm text-gray-800 dark:text-white mt-1">{{ $order->address->first_name }} {{ $order->address->last_name }}</span>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
            <span class="block text-xs font-bold text-gray-400 uppercase">Order Date</span>
            <span class="block font-bold text-sm text-gray-800 dark:text-white mt-1">{{ $order->created_at->format('d M, Y') }}</span>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
            <span class="block text-xs font-bold text-gray-400 uppercase">Order Status</span>
            @php
                $orderStatusClasses = [
                    'new' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                    'processing' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400',
                    'shipped' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                    'delivered' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                ];
                $statusClass = $orderStatusClasses[$order->status] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $statusClass }} capitalize mt-1.5">
                {{ $order->status }}
            </span>
        </div>
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-2xl p-5 shadow-sm">
            <span class="block text-xs font-bold text-gray-400 uppercase">Payment Status</span>
            @php
                $paymentStatusClasses = [
                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                    'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                ];
                $payClass = $paymentStatusClasses[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $payClass }} capitalize mt-1.5">
                {{ $order->payment_status }}
            </span>
        </div>
    </div>

    <!-- Items & Shipping Grid -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Products List -->
        <div class="w-full lg:w-3/4 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl overflow-hidden shadow-sm">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full min-w-[550px] text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-slate-800/80 pb-4 text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                                <th class="py-3">Product</th>
                                <th class="py-3">Price</th>
                                <th class="py-3">Quantity</th>
                                <th class="py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-800/50">
                            @foreach ($order->items as $item)
                                <tr class="align-middle" wire:key="order-item-{{ $item->id }}">
                                    <td class="py-4 pr-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-14 h-14 bg-slate-50 dark:bg-slate-950/20 border border-gray-100 dark:border-slate-800/60 rounded-xl overflow-hidden flex items-center justify-center p-1.5 flex-shrink-0">
                                                @if(!empty($item->product->images) && isset($item->product->images[0]))
                                                    <img class="object-contain w-full h-full" src="{{ url('storage', $item->product->images[0]) }}" alt="{{ $item->product->name }}">
                                                @else
                                                    <img class="object-contain w-full h-full" src="https://placehold.co/150x150/6366f1/ffffff?text={{ urlencode($item->product->name ?? 'Product') }}" alt="Product Image">
                                                @endif
                                            </div>
                                            <div>
                                                <span class="font-bold text-gray-800 dark:text-gray-200 text-sm line-clamp-1">{{ $item->product->name ?? 'Deleted Product' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 text-sm font-semibold text-gray-600 dark:text-slate-300">
                                        {{ Number::currency($item->unit_amount, 'INR') }}
                                    </td>
                                    <td class="py-4 text-sm font-semibold text-gray-800 dark:text-white">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="py-4 text-right font-extrabold text-blue-600 dark:text-blue-400 text-sm">
                                        {{ Number::currency($item->total_amount, 'INR') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 shadow-sm space-y-4">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white pb-3 border-b border-gray-100 dark:border-slate-800/80">Shipping Details</h2>
                <div class="text-sm text-gray-600 dark:text-slate-400 space-y-2">
                    <p class="font-bold text-gray-800 dark:text-white text-base">
                        {{ $order->address->first_name }} {{ $order->address->last_name }}
                    </p>
                    <p>{{ $order->address->street_address }}</p>
                    <p>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}</p>
                    <p class="pt-2 font-medium">📞 Phone: {{ $order->address->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Summary Column -->
        <div class="w-full lg:w-1/4">
            <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 shadow-sm space-y-6">
                <h2 class="text-lg font-bold text-gray-800 dark:text-white border-b border-gray-100 dark:border-slate-800/80 pb-3">Price Summary</h2>
                
                <div class="space-y-3">
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
                </div>

                <div class="border-t border-gray-100 dark:border-slate-800/80 pt-4 flex justify-between items-center text-base font-bold">
                    <span class="text-gray-800 dark:text-white">Total</span>
                    <span class="text-xl font-extrabold text-blue-600 dark:text-blue-400">{{ Number::currency($order->grand_total, 'INR') }}</span>
                </div>

                <div class="pt-2">
                    <a wire:navigate href="/my-orders" class="w-full py-2.5 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 dark:border-slate-700 dark:text-gray-300 dark:hover:bg-slate-800 transition">
                        Back to My Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>