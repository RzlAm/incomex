<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ThisPeriodStats extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static bool $isLazy = false;

    public function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $startDay = now()->startOfDay();
        $endDay = now()->endOfDay();

        $startMonth = now()->startOfMonth();
        $endMonth = now()->endOfMonth();

        $currency = Setting::first()?->currency ?? 'Rp';

        $totalIncomeToday = Transaction::where('type', 'income')
            ->whereBetween('date_time', [$startDay, $endDay])
            ->when(Setting::first()?->exclude_internal_transfer, fn($q) => $q->where('category_id', '!=', 1))
            ->sum('amount');

        $totalExpenseToday = Transaction::where('type', 'expense')
            ->whereBetween('date_time', [$startDay, $endDay])
            ->when(Setting::first()?->exclude_internal_transfer, fn($q) => $q->where('category_id', '!=', 1))
            ->sum('amount');

        $totalIncomeMonth = Transaction::where('type', 'income')
            ->whereBetween('date_time', [$startMonth, $endMonth])
            ->when(Setting::first()?->exclude_internal_transfer, fn($q) => $q->where('category_id', '!=', 1))
            ->sum('amount');

        $totalExpenseMonth = Transaction::where('type', 'expense')
            ->whereBetween('date_time', [$startMonth, $endMonth])
            ->when(Setting::first()?->exclude_internal_transfer, fn($q) => $q->where('category_id', '!=', 1))
            ->sum('amount');

        return [
            Stat::make('Income This Day', $currency . number_format($totalIncomeToday, 2, ',', '.'))
                ->icon('heroicon-o-arrow-down-circle')
                ->color('success')
                ->description('+ ' . $currency . number_format($totalIncomeMonth, 2, ',', '.') . ' this month'),

            Stat::make('Expense This Day', $currency . number_format($totalExpenseToday, 2, ',', '.'))
                ->icon('heroicon-o-arrow-up-circle')
                ->color('danger')
                ->description('- ' . $currency . number_format($totalExpenseMonth, 2, ',', '.') . ' this month'),
        ];
    }
}
