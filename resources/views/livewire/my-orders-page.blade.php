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
                    <span class="text-gray-800 dark:text-white font-semibold">My Orders</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-2xl mx-auto mb-10">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-800 dark:text-white sm:text-4xl">My Orders</h1>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-2">Track your past purchases and current orders.</p>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl p-16 text-center shadow-sm max-w-3xl mx-auto">
            <i class="bi bi-box-seam text-6xl text-slate-350 block mb-4"></i>
            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mt-6">No Orders Placed Yet</h3>
            <p class="text-gray-500 dark:text-slate-400 text-sm mt-2 max-w-sm mx-auto">You haven't ordered anything yet. When you place an order, it will appear here.</p>
            <div class="mt-8">
                <a wire:navigate href="/products" class="py-3 px-6 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-xl border border-transparent bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-500/10 hover:shadow-blue-500/20 transition hover-lift">
                    Start Shopping
                </a>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800/80 rounded-3xl overflow-hidden shadow-sm">
            <div class="p-6 overflow-x-auto">
                <table class="w-full min-w-[700px] text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-slate-800/80 pb-4 text-xs font-bold text-gray-400 dark:text-slate-500 uppercase tracking-wider">
                            <th class="py-3">Order ID</th>
                            <th class="py-3">Date</th>
                            <th class="py-3">Order Status</th>
                            <th class="py-3">Payment Status</th>
                            <th class="py-3">Total Amount</th>
                            <th class="py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-800/50">
                        @foreach ($orders as $order)
                            <tr class="align-middle" wire:key="order-row-{{ $order->id }}">
                                <td class="py-4 font-bold text-sm text-gray-800 dark:text-white">
                                    #{{ $order->id }}
                                </td>
                                <td class="py-4 text-sm text-gray-600 dark:text-slate-400">
                                    {{ $order->created_at->format('d M, Y') }}
                                </td>
                                <td class="py-4 text-sm">
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
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClass }} capitalize">
                                        {{ $order->status }}
                                    </span>
                                </td>
                                <td class="py-4 text-sm">
                                    @php
                                        $paymentStatusClasses = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                            'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                        $payClass = $paymentStatusClasses[$order->payment_status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold {{ $payClass }} capitalize">
                                        {{ $order->payment_status }}
                                    </span>
                                </td>
                                <td class="py-4 font-extrabold text-blue-600 dark:text-blue-400 text-sm">
                                    {{ Number::currency($order->grand_total, 'INR') }}
                                </td>
                                <td class="py-4 text-right">
                                    <a wire:navigate href="/my-orders/{{ $order->id }}" class="py-1.5 px-3.5 inline-flex items-center gap-x-2 text-xs font-semibold rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 dark:border-slate-700 dark:text-gray-300 dark:hover:bg-slate-800 transition">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-end">
            {{ $orders->links() }}
        </div>
    @endif
</div>