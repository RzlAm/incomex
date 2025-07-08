<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Category;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\Wallet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('schedule_name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Select::make('schedule_type')
                    ->options([
                        'daily' => 'Daily',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ])
                    ->default('daily')
                    ->reactive()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('day')
                    ->numeric()
                    ->default(null)
                    ->visible(fn($get) => in_array($get('schedule_type'), ['monthly', 'yearly'])),

                Forms\Components\TextInput::make('month')
                    ->numeric()
                    ->default(null)
                    ->visible(fn($get) => $get('schedule_type') === 'yearly'),

                Forms\Components\TextInput::make('hour')
                    ->numeric()
                    ->default(null)
                    ->visible(fn($get) => in_array($get('schedule_type'), ['hourly', 'daily', 'monthly', 'yearly'])),

                Forms\Components\TextInput::make('minute')
                    ->numeric()
                    ->default(0)
                    ->visible(fn($get) => in_array($get('schedule_type'), ['hourly', 'daily', 'monthly', 'yearly'])),

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
                Tables\Columns\TextColumn::make('schedule_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('schedule_type'),
                Tables\Columns\TextColumn::make('day')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('month')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('hour')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('minute')
                    ->numeric()
                    ->sortable(),
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
                Tables\Columns\TextColumn::make('last_run_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(25)
                    ->tooltip(fn($record) => $record->description)
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ManageSchedules::route('/'),
        ];
    }
}
