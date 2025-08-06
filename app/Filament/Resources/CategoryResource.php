<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Money';
    public static function getNavigationBadge(): ?string
    {
        return (string) Category::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(1)->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(100)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $set) {
                            $bg = substr(str_shuffle('ABCDEF0123456789'), 0, 6);

                            // Hitung brightness bg: (R*299 + G*587 + B*114) / 1000
                            $r = hexdec(substr($bg, 0, 2));
                            $g = hexdec(substr($bg, 2, 2));
                            $b = hexdec(substr($bg, 4, 2));
                            $brightness = ($r * 299 + $g * 587 + $b * 114) / 1000;

                            // Jika brightness tinggi → teks hitam, jika gelap → teks putih
                            $color = $brightness > 128 ? '000000' : 'ffffff';

                            $url = "https://ui-avatars.com/api/?name=" . urlencode($state) .
                                "&background={$bg}&color={$color}";

                            $set('icon', $url);
                            $set('slug', Str::slug($state));
                        }),

                    TextInput::make('slug')
                        ->required(),

                    TextInput::make('icon')
                        ->required()
                        ->maxLength(255)
                        ->label('Icon URL'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('icon')
                    ->circular(true),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
