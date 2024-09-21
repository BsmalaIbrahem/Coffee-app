<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;

class ProductResource extends Resource
{
    use Translatable;
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPluralModelLabel(): string
    {
        return __('filament.Products');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                ->label(__('filament.Category'))
                ->options(\App\Models\Category::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),

                Forms\Components\TextInput::make('name')
                ->label(__('filament.Name'))
                ->required()
                ->maxLength(255)
                ->unique(),

                Forms\Components\TextInput::make('description')
                ->label(__('filament.Description'))
                ->required()
                ->maxLength(255)
                ->unique(),

                Forms\Components\TextInput::make('ingredients')
                ->label(__('filament.Ingredients'))
                ->maxLength(255)
                ->unique(),

                Forms\Components\TextInput::make('how_to_prepare')
                ->label(__('filament.HowToPrepare'))
                ->maxLength(255)
                ->unique(),

                Forms\Components\FileUpload::make('main_image')
                ->disk('public')
                ->directory('products')
                ->required()
                ->image()
                ->label(__('filament.Image')),

                
                Forms\Components\TextInput::make('price')
                ->numeric()
                ->required()
                ->label(__('filament.Price')),

                Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->default(0)
                ->label(__('filament.Quantity')),

                Forms\Components\Toggle::make('is_unlimited')
                ->label(__('filament.UnLimited'))
                ->onIcon('heroicon-m-bolt')
                ->offIcon('heroicon-m-user'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('category.name')
                    ->label(__('filament.Category'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('filament.Name'))
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('description')
                    ->label(__('filament.Description'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('ingredients')
                    ->label(__('filament.Ingredients'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('how_to_prepare')
                    ->label(__('filament.HowToPrepare'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label(__('filament.Price')),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('filament.Quantity')),

                Tables\Columns\IconColumn::make('is_unlimited')
                    ->boolean()
                    ->label(__('filament.UnLimited')),

                Tables\Columns\ImageColumn::make('main_image')
                    ->label(__('filament.Image')),

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
            RelationManagers\VariantsRelationManager::Class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
