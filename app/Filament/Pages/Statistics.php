<?php

namespace App\Filament\Pages;

use App\Models\Transaction;
use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Http\Request;

class Statistics extends Page implements Forms\Contracts\HasForms
{
    public ?string $startDate = null;
    public ?string $endDate = null;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.statistics';
    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Statistics';

    public array $statisticsData = [];
    public array $categoryData = [];
    public int $totalIncome = 0;
    public int $totalExpense = 0;

    function darkenColor($hex, $percent = 20)
    {
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $r = max(0, $r - ($r * $percent / 100));
        $g = max(0, $g - ($g * $percent / 100));
        $b = max(0, $b - ($b * $percent / 100));

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    public function mount(Request $request)
    {
        $data = $request->validate([
            'startDate' => 'nullable',
            'endDate' => 'nullable',
        ]);

        $this->startDate = $data['startDate'] ?? now()->startOfMonth()->toDateString();
        $this->endDate = $data['endDate'] ?? now()->endOfMonth()->toDateString();
        $this->setChartData();
    }

    public function setChartData()
    {
        // Statistics Chart
        $start = $this->startDate ?? now()->startOfMonth()->toDateString();
        $end = $this->endDate ?? now()->endOfMonth()->toDateString();
        $start = \Carbon\Carbon::parse($start)->startOfDay();
        $end = \Carbon\Carbon::parse($end)->endOfDay();

        $incomeData = \App\Models\Transaction::where('type', 'income')
            ->whereBetween('date_time', [$start, $end])
            ->selectRaw('DATE(date_time) as date, SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        $expenseData = \App\Models\Transaction::where('type', 'expense')
            ->whereBetween('date_time', [$start, $end])
            ->selectRaw('DATE(date_time) as date, SUM(amount) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();


        $this->totalIncome = \App\Models\Transaction::where('type', 'income')
            ->whereBetween('date_time', [$start, $end])
            ->sum('amount');

        $this->totalExpense = \App\Models\Transaction::where('type', 'expense')
            ->whereBetween('date_time', [$start, $end])
            ->sum('amount');

        $labels = [];
        $income = [];
        $expense = [];
        $period = $start->copy();
        while ($period->lte($end)) {
            $dateKey = $period->format('Y-m-d');
            $labels[] = $period->format('d M Y');
            $income[] = $incomeData[$dateKey] ?? 0;
            $expense[] = $expenseData[$dateKey] ?? 0;
            $period->addDay();
        }

        // Category Chart
        $categoryData = \App\Models\Transaction::whereBetween('date_time', [$start, $end])
            ->selectRaw('category_id, SUM(amount) as total')
            ->groupBy('category_id', 'type')
            ->orderByDesc('total')
            ->with('category')
            ->limit(10)
            ->get();

        $this->statisticsData = [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Income',
                    'backgroundColor' => '#16a34a',
                    'borderWidth' => 1,
                    'borderColor' => '#0f7d38',
                    'borderRadius' => 4,
                    'barThickness' => 12,
                    'data' => $income,
                ],
                [
                    'label' => 'Expense',
                    'backgroundColor' => '#dc2626',
                    'borderWidth' => 1,
                    'borderColor' => '#ba2020',
                    'borderRadius' => 4,
                    'barThickness' => 12,
                    'data' => $expense,
                ],
            ],
        ];

        $bgColors = [
            '#f87171',
            '#fbbf24',
            '#34d399',
            '#accdfc',
            '#a78bfa',
            '#f8cd71',
            '#b5eb4b',
            '#11cdde',
            '#704ce6',
            "#ef8bfa"
        ];

        $borderColors = array_map(fn($color) => $this->darkenColor($color, 25), $bgColors);

        $this->categoryData = [
            'labels' => $categoryData->pluck('category.name')->toArray(),
            'datasets' => [
                [
                    'data' => $categoryData->pluck('total')->toArray(),
                    'backgroundColor' => $bgColors,
                    'borderColor' => $borderColors,
                    'borderWidth' => 1,
                ],
            ],
        ];
    }

    public function exportCSV(Request $request)
    {
        $startDate = $request->input('startDate') ?? now()->startOfMonth()->toDateString();
        $endDate = $request->input('endDate') ?? now()->endOfMonth()->toDateString();

        $start = \Carbon\Carbon::parse($startDate)->startOfDay();
        $end = \Carbon\Carbon::parse($endDate)->endOfDay();

        $transactions = Transaction::with('category')->whereBetween('date_time', [$start, $end])->orderBy('date_time', 'ASC')->get();

        $filename = 'Incomex_Export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($transactions) {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "Date;Category;Type;Amount;Description\n");

            foreach ($transactions as $transaction) {
                $row = [
                    $transaction->date_time,
                    $transaction->category->name ?? '',
                    ucfirst($transaction->type),
                    number_format($transaction->amount, 2, ',', ''),
                    $transaction->description ?? '',
                ];

                fwrite($handle, implode(';', $row) . "\n");
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
