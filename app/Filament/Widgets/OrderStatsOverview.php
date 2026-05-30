<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class OrderStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalSales = Order::where('payment_status', 'paid')->sum('grand_total');
        $ordersCount = Order::count();
        $productsCount = Product::where('is_active', 1)->count();
        $customersCount = User::count();

        // Weekly sales trend chart mock data points
        $salesTrend = Order::where('payment_status', 'paid')
            ->latest()
            ->take(10)
            ->pluck('grand_total')
            ->toArray();

        return [
            Stat::make('Total Revenue', Number::currency($totalSales, 'INR'))
                ->description('Total completed sales revenue')
                ->descriptionIcon('heroicon-m-currency-rupee')
                ->chart(!empty($salesTrend) ? array_reverse($salesTrend) : [1000, 2000, 1500, 3000, 2500, 4000])
                ->color('success'),

            Stat::make('Total Orders', $ordersCount)
                ->description('Overall orders volume')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->chart([3, 5, 2, 7, 6, 8, 10])
                ->color('info'),

            Stat::make('Active Catalog Products', $productsCount)
                ->description('Active electronics in inventory')
                ->descriptionIcon('heroicon-m-squares-2x2')
                ->color('warning'),

            Stat::make('Registered Customers', $customersCount)
                ->description('Registered user accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
        ];
    }
}
