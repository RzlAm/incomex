<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Wallet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Balances extends BaseWidget
{
    public function getColumns(): int
    {
        return 3;
    }

    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $balances = Transaction::selectRaw("
            wallet_id,
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) -
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as balance
        ")
            ->groupBy('wallet_id')
            ->pluck('balance', 'wallet_id');

        $currency = Setting::first()?->currency ?? 'Rp';

        $stats = [];

        foreach ($balances as $walletId => $balance) {
            $wallet = Wallet::find($walletId);
            $walletName = $wallet?->name ?? "Wallet #$walletId";

            $stats[] = Stat::make($walletName, $currency . ' ' . number_format($balance, 2, ',', '.'))
                ->icon('heroicon-o-wallet');
        }

        return $stats;
    }
}
