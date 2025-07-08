<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Table;

class LatestTransactions extends BaseWidget
{
	protected static ?int $sort = 4;

	protected int | string | array $columnSpan = 'full';
	protected static bool $isLazy = false;
	protected static ?string $heading = 'Latest Transactions';

	public function table(Table $table): Table
	{
		return $table
			->query(
				Transaction::query()->latest('date_time')
			)
			->paginated(false)
			->columns([
				Tables\Columns\TextColumn::make('category.name')
					->label('Category')
					->formatStateUsing(
						fn($state, $record) =>
						'<div style="display: flex; align-items: center; gap: 0.5rem;">' .
							'<img src="' . e($record->category->icon) . '" alt="Icon" style="width:24px; height:24px; object-fit: contain; border-radius: 50%;">' .
							'<span>' . e($state) . '</span>' .
							'</div>'
					)
					->html()
					->sortable(),
				Tables\Columns\TextColumn::make('type')
					->label('Type')
					->badge()
					->formatStateUsing(fn($state) => match ($state) {
						'income' => 'Income',
						'expense' => 'Expense',
						default => $state,
					})
					->colors([
						'success' => 'income',
						'danger' => 'expense',
					])
					->sortable(),
				Tables\Columns\TextColumn::make('amount')
					->label('Amount')
					->sortable()
					->formatStateUsing(function ($state) {
						static $currency = null;

						if (is_null($currency)) {
							$currency = Setting::first()?->currency ?? 'Rp';
						}

						return $currency . number_format($state, 2, ',', '.');
					}),
				Tables\Columns\TextColumn::make('date_time')
					->label('Time')
					->sortable()
					->formatStateUsing(fn($state) => Carbon::parse($state)->format('d M Y H:i'))
			]);
	}
}
