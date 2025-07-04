<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Wallet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Balance extends BaseWidget
{
    protected static ?int $columns = 2; // maksimal 3 kolom

    protected function getStats(): array
    {
        $totalBalance = Transaction::selectRaw("
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) -
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as balance
        ")->value('balance') ?? 0;

        $balances = Transaction::selectRaw("
            wallet_id,
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) -
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as balance
        ")
            ->groupBy('wallet_id')
            ->pluck('balance', 'wallet_id');

        $currency = Setting::first()?->currency ?? 'Rp';

        $stats = [];

        $stats[] = Stat::make('Total Balance', $currency . ' ' . number_format($totalBalance, 2, ',', '.'));

        foreach ($balances as $walletId => $balance) {
            $wallet = Wallet::find($walletId);
            $walletName = $wallet?->name ?? "Wallet #$walletId";

            $stats[] = Stat::make($walletName, $currency . ' ' . number_format($balance, 2, ',', '.'));
        }

        return $stats;
    }
}
