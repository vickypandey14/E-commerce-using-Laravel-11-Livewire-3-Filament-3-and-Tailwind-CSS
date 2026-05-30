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
                    <a href="/my-orders" class="hover:text-blue-600 dark:hover:text-blue-500">My Orders</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="bi bi-chevron-right mx-1 text-gray-400 dark:text-slate-650 text-[10px]"></i>
                    <span class="text-gray-800 dark:text-white font-semibold">Order #{{ $order->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-2xl mx-auto mb-10">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 dark:text-white sm:text-4xl">Order Details</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">Detailed summary of Order #{{ $order->id }}.</p>
    </div>

    @if($order->status === 'cancelled')
        <div class="bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 p-5 rounded-3xl border border-red-200/50 mb-8 flex items-center gap-3">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-bold text-sm">Order Cancelled</h4>
                <p class="text-xs mt-0.5">This order has been cancelled and cannot be processed further.</p>
            </div>
        </div>
    @else
        <!-- Order Tracking Stepper -->
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-6 sm:p-8 shadow-sm mb-8">
            <h3 class="text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider mb-6">Order Tracking</h3>
            
            <div class="relative flex flex-col md:flex-row justify-between items-center gap-6 md:gap-2">
                <!-- Line Connector -->
                <div class="absolute left-5 top-5 bottom-5 md:left-0 md:right-0 md:top-1/2 md:bottom-auto w-0.5 md:w-full h-full md:h-1 bg-gray-100 dark:bg-slate-800 -translate-y-1/2 md:translate-y-0 z-0"></div>
                
                @php
                    $steps = [
                        'new' => ['label' => 'Order Placed', 'icon' => 'bi-receipt'],
                        'processing' => ['label' => 'Processing', 'icon' => 'bi-gear'],
                        'shipped' => ['label' => 'Shipped', 'icon' => 'bi-truck'],
                        'delivered' => ['label' => 'Delivered', 'icon' => 'bi-check2-circle']
                    ];
                    
                    $statusOrder = ['new', 'processing', 'shipped', 'delivered'];
                    $currentStatusIndex = array_search($order->status, $statusOrder);
                    if ($currentStatusIndex === false) { $currentStatusIndex = 0; }
                @endphp

                @foreach($statusOrder as $index => $stepKey)
                    @php
                        $step = $steps[$stepKey];
                        $isCompleted = $index < $currentStatusIndex;
                        $isCurrent = $index === $currentStatusIndex;
                        
                        $circleClass = $isCompleted 
                            ? 'bg-blue-600 border-blue-600 text-white' 
                            : ($isCurrent ? 'bg-blue-100 border-blue-600 text-blue-600 dark:bg-blue-950/40 dark:text-blue-400' : 'bg-white dark:bg-slate-900 border-gray-200 text-gray-450 dark:border-slate-800');
                        $labelClass = $isCompleted || $isCurrent ? 'text-blue-600 dark:text-blue-400 font-bold' : 'text-gray-400 dark:text-slate-500 font-medium';
                    @endphp
                    
                    <div class="relative flex md:flex-col items-center gap-4 md:gap-2 z-10 w-full md:w-auto">
                        <!-- Step Circle -->
                        <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm shadow-sm transition {{ $circleClass }}">
                            @if($isCompleted)
                                <i class="bi bi-check-lg text-base"></i>
                            @else
                                <i class="bi {{ $step['icon'] }} text-base"></i>
                            @endif
                        </div>
                        <!-- Step Label -->
                        <div class="text-left md:text-center">
                            <span class="block text-xs uppercase tracking-wider {{ $labelClass }}">{{ $step['label'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

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
                        <span class="font-semibold text-gray-800 dark:text-white">{{ Number::currency($order->grand_total - $order->shipping_amount + $order->discount_amount, 'INR') }}</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between text-sm text-gray-600 dark:text-slate-400">
                            <span>Discount ({{ $order->coupon_code }})</span>
                            <span class="font-semibold text-red-500">-{{ Number::currency($order->discount_amount, 'INR') }}</span>
                        </div>
                    @endif
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