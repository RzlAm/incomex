<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class Chart extends ChartWidget
{
    protected static ?string $heading = 'Statistic';
    protected static ?string $maxHeight = '280px';
    protected static ?int $sort = 3;
    protected static string $color = 'primary';
    protected int | string | array $columnSpan = 'full';
    public ?string $filter = 'month';
    protected static bool $isLazy = false;

    protected function getFilters(): ?array
    {
        return [
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $start = now();
        $end = now();

        switch ($this->filter) {
            case 'week':
                $start = Carbon::now()->startOfWeek();
                $end = Carbon::now()->endOfWeek();
                break;
            case 'year':
                $start = Carbon::now()->startOfYear();
                $end = Carbon::now()->endOfYear();
                break;
            case 'month':
            default:
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
        }

        $incomeData = Transaction::where('type', 'income')
            ->whereBetween('date_time', [$start, $end])
            ->selectRaw('DATE(date_time) as date, SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $expenseData = Transaction::where('type', 'expense')
            ->whereBetween('date_time', [$start, $end])
            ->selectRaw('DATE(date_time) as date, SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $labels = [];
        $period = $start->copy();
        while ($period->lte($end)) {
            $labels[] = $period->format('d M');
            $period->addDay();
        }

        $income = [];
        $expense = [];

        foreach ($labels as $label) {
            $dateKey = Carbon::createFromFormat('d M', $label)->setYear($start->year)->format('Y-m-d');

            $income[] = $incomeData[$dateKey] ?? 0;
            $expense[] = $expenseData[$dateKey] ?? 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Income',
                    'backgroundColor' => '#16a34a',
                    'borderWidth' => 2,
                    'borderColor' => '#0f7d38',
                    'borderRadius' => 4,
                    'barThickness' => 12,
                    'data' => $income,
                ],
                [
                    'label' => 'Expense',
                    'backgroundColor' => '#dc2626',
                    'borderWidth' => 2,
                    'borderColor' => '#ba2020',
                    'borderRadius' => 4,
                    'barThickness' => 12,
                    'data' => $expense,
                ],
            ],
        ];
    }
}
