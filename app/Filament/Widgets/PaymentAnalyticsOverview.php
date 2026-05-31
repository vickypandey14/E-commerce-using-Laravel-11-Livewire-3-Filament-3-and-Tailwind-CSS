<?php

namespace App\Filament\Widgets;

use App\Models\PaymentTransaction;
use App\Models\PaymentGateway;
use App\Models\PaymentRefund;
use App\Models\PaymentDispute;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class PaymentAnalyticsOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // 1. Total Payment Volume (TPV)
        $tpv = cache()->remember('payment_stats_tpv', 60, function () {
            return PaymentTransaction::where('type', 'payment')
                ->where('status', 'completed')
                ->sum('amount');
        });

        // 2. Active Gateway count
        $activeGateways = cache()->remember('payment_stats_gateways_count', 60, function () {
            return PaymentGateway::active()->count();
        });

        // 3. Total Refunds Amount
        $totalRefunds = cache()->remember('payment_stats_refunds_amount', 60, function () {
            return PaymentRefund::where('status', 'processed')->sum('amount');
        });

        // 4. Opened Disputes count
        $disputesCount = cache()->remember('payment_stats_disputes_count', 60, function () {
            return PaymentDispute::whereIn('status', ['opened', 'under_review'])->count();
        });

        // TPV Trend mock/real values
        $tpvTrend = cache()->remember('payment_stats_tpv_trend', 60, function () {
            return PaymentTransaction::where('type', 'payment')
                ->where('status', 'completed')
                ->latest()
                ->take(7)
                ->pluck('amount')
                ->toArray();
        });

        return [
            Stat::make('Total Payment Volume (TPV)', Number::currency($tpv, 'INR'))
                ->description('Total volume processed via active gateways')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart(!empty($tpvTrend) ? array_reverse($tpvTrend) : [2000, 4500, 3000, 7500, 5000, 9000, 8500])
                ->color('success'),

            Stat::make('Active Payments Providers', $activeGateways)
                ->description('Configured gateway integrations')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),

            Stat::make('Total Refunds Issued', Number::currency($totalRefunds, 'INR'))
                ->description('Processed full/partial refunds')
                ->descriptionIcon('heroicon-m-arrow-uturn-left')
                ->color('warning'),

            Stat::make('Active Disputes & Chargebacks', $disputesCount)
                ->description('Disputes currently under review')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color($disputesCount > 0 ? 'danger' : 'success'),
        ];
    }
}
