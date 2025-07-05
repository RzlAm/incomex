<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ThisPeriodStats extends BaseWidget
{
    protected static ?int $sort = 1;

    public function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $start = now();
        $end = now();

        $start = now()->startOfDay();
        $end = now()->endOfDay();

        $currency = Setting::first()?->currency ?? 'Rp';

        $totalIncome = Transaction::where('type', 'income')
            ->whereBetween('date_time', [$start, $end])
            ->sum('amount');

        $totalExpense = Transaction::where('type', 'expense')
            ->whereBetween('date_time', [$start, $end])
            ->sum('amount');

        return [
            Stat::make('Income This Day', $currency . ' ' . number_format($totalIncome, 2, ',', '.'))
                ->icon('heroicon-o-arrow-trending-up')
                ->color('success'),

            Stat::make('Expense This Day', $currency . ' ' . number_format($totalExpense, 2, ',', '.'))
                ->icon('heroicon-o-arrow-trending-down')
                ->color('danger'),
        ];
    }
}
