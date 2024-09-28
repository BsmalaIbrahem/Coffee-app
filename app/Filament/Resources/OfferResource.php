<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OfferResource\Pages;
use App\Filament\Resources\OfferResource\RelationManagers;
use App\Models\Offer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;

class OfferResource extends Resource
{
    protected static ?string $model = Offer::class;

    protected static ?string $navigationGroup = 'Offer';

    protected static ?string $navigationIcon = 'heroicon-o-minus-circle';

    public static function getPluralModelLabel(): string
    {
        return __('filament.Offers');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Create New Offer')
                ->tabs([
                    Tabs\Tab::make(__('filament.Offer'))
                    ->schema([
                        Forms\Components\TextInput::make('value')
                        ->label(__('filament.Value'))
                        ->required()
                        ->numeric(),

                        Forms\Components\Select::make('type')
                        ->label(__('filament.Type'))
                        ->required()
                        ->options([
                            'flat' => 'flat',
                            'percentage' => 'percentage'
                        ])->default('percentage'),

                        
                        Forms\Components\DateTimePicker::make('start_date')
                        ->label(__('filament.StartDate')),

                        Forms\Components\DateTimePicker::make('end_date')
                        ->label(__('filament.EndDate')),

                        Forms\Components\Toggle::make('is_global')
                        ->label(__('filament.isGlobal'))
                        ->onIcon('heroicon-m-bolt')
                        ->offIcon('heroicon-m-user'),
                    ]),

                    Tabs\Tab::make(__('filament.Categories'))
                    ->schema([
                        Forms\Components\Select::make('categories')
                        ->label(__('filament.Categories'))
                        ->multiple()
                        ->options(\App\Models\Category::all()->pluck('name', 'id')),
                    ])->visibleOn('create'),

                    Tabs\Tab::make(__('filament.Products'))
                    ->schema([
                        Forms\Components\Select::make('products')
                        ->label(__('filament.Products'))
                        ->multiple()
                        ->options(\App\Models\Product::all()->pluck('name', 'id')),
                    ])->visibleOn('create'),
                ]),

                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label(__('filament.Value'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label(__('filament.Type')),

                Tables\Columns\TextColumn::make('start_date')
                    ->label(__('filament.StartDate')),

                Tables\Columns\TextColumn::make('end_date')
                    ->label(__('filament.EndDate')),

                Tables\Columns\IconColumn::make('is_global')
                    ->boolean()
                    ->label(__('filament.isGlobal')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::Class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOffers::route('/'),
            'create' => Pages\CreateOffer::route('/create'),
            'edit' => Pages\EditOffer::route('/{record}/edit'),
        ];
    }
}
