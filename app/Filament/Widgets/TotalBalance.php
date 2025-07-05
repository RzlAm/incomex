<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalBalance extends BaseWidget
{
    public function getColumns(): int
    {
        return 1;
    }

    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $totalBalance = Transaction::selectRaw("
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) -
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as balance
        ")->value('balance') ?? 0;

        $currency = Setting::first()?->currency ?? 'Rp';

        $stats = [];
        $stats[] = Stat::make('Total Balance', $currency . ' ' . number_format($totalBalance, 2, ',', '.'))
            ->icon('heroicon-o-currency-dollar');

        return $stats;
    }
}
