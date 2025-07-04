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

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('wallet_id')
                    ->label('Wallet')
                    ->required()
                    ->options(
                        Wallet::all()->pluck('name', 'id')->toArray()
                    )
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->required()
                    ->options(
                        Category::all()->pluck('name', 'id')->toArray()
                    )
                    ->searchable(),
                Forms\Components\DateTimePicker::make('date_time')
                    ->required(),
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
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                Tables\Columns\TextColumn::make('wallet.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->format('d M Y H:i')),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(25)
                    ->tooltip(fn($record) => $record->description),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTransactions::route('/'),
        ];
    }
}
