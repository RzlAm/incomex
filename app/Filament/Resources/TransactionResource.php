<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Transaction;
use App\Models\Wallet;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        return (string) Transaction::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('wallet_id')
                    ->label('Wallet')
                    ->required()
                    ->options(Wallet::all()->pluck('name', 'id')->toArray())
                    ->searchable(),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->options(Category::all()->pluck('name', 'id')->toArray())
                    ->searchable(),
                Forms\Components\DateTimePicker::make('date_time')->required(),
                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options([
                        'income' => 'Income',
                        'expense' => 'Expense',
                    ])
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Transaction::query()->latest('date_time'))
            ->columns([
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
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
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->colors([
                        'success' => 'income',
                        'danger' => 'expense',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('wallet.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->searchable()
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
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('d M Y H:i')),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(25)
                    ->tooltip(fn($record) => $record->description),
            ])
            ->filters([
                Filter::make('date_time')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From'),
                        Forms\Components\DatePicker::make('until')->label('Until'),
                    ])
                    ->columns(2)
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('date_time', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('date_time', '<=', $data['until']));
                    }),
                SelectFilter::make('type')
                    ->options([
                        'income' => 'Income',
                        'expense' => 'Expense',
                    ])
                    ->label('Type'),
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(fn() => Category::all()->pluck('name', 'id'))
                    ->searchable(),
                Filter::make('amount_range')
                    ->label('Amount Range')
                    ->form([
                        Forms\Components\TextInput::make('min')->numeric()->label('Min'),
                        Forms\Components\TextInput::make('max')->numeric()->label('Max'),
                    ])
                    ->columns(2)
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['min'], fn($q) => $q->where('amount', '>=', $data['min']))
                            ->when($data['max'], fn($q) => $q->where('amount', '<=', $data['max']));
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->contentFooter(
                function ($livewire) {
                    $query = $livewire->getFilteredTableQuery();

                    $income = (clone $query)
                        ->where('type', 'income')
                        ->when(Setting::first()?->exclude_internal_transfer, fn($q) => $q->where('category_id', '!=', 1))
                        ->sum('amount');

                    $expense = (clone $query)
                        ->where('type', 'expense')
                        ->when(Setting::first()?->exclude_internal_transfer, fn($q) => $q->where('category_id', '!=', 1))
                        ->sum('amount');

                    $currency = Setting::first()?->currency ?? 'Rp';
                    return view('components.transaction-summary', [
                        'income' => $currency . number_format($income, 2, ',', '.'),
                        'expense' => $currency . number_format($expense, 2, ',', '.'),
                        'netBalance' => number_format($income - $expense, 2, ',', '.')
                    ]);
                }
            );
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTransactions::route('/'),
        ];
    }
}
