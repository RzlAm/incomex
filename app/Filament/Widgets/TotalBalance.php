<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\HtmlString;

class TotalBalance extends BaseWidget
{
    public bool $showBalance = false;

    public function toggleBalance()
    {
        $this->showBalance = !$this->showBalance;
    }

    protected static ?int $sort = 0;
    protected static bool $isLazy = false;

    public function getColumns(): int
    {
        return 1;
    }

    protected function getStats(): array
    {
        $totalBalance = Transaction::selectRaw("
            SUM(CASE WHEN type = 'income' THEN amount ELSE 0 END) -
            SUM(CASE WHEN type = 'expense' THEN amount ELSE 0 END) as balance
        ")->value('balance') ?? 0;

        $currency = Setting::first()?->currency ?? 'Rp';

        $displayValue = $this->showBalance
            ? $currency . number_format($totalBalance, 2, ',', '.')
            : '••••••••';

        $eyeIcon = $this->showBalance
            ? 'heroicon-o-eye-slash'
            : 'heroicon-o-eye';

        $balanceWithIcon = new HtmlString(view('components.toggle-balance', [
            'balance' => $displayValue,
            'eyeIcon' => $eyeIcon,
            'action' => 'toggleBalance',
        ])->render());

        return [
            Stat::make('Total Balance', $balanceWithIcon)
                ->icon('heroicon-o-currency-dollar')
                ->color('success')
                ->extraAttributes(['class' => 'relative']),
        ];
    }
}
