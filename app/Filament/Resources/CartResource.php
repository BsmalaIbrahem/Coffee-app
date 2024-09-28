<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CartResource\Pages;
use App\Filament\Resources\CartResource\RelationManagers;
use App\Models\Cart;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static ?string $navigationGroup = 'User';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.email')
                    ->label(__('filament.Email'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('phone.phone')
                    ->label(__('filament.Phones'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('total')
                    ->label(__('filament.Total'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('delivery_fee')
                    ->label(__('filament.DeliveryFee'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('filament.Quantity'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('address_details')
                    ->label(__('filament.Address'))
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarts::route('/'),
           // 'create' => Pages\CreateCart::route('/create'),
           // 'edit' => Pages\EditCart::route('/{record}/edit'),
        ];
    }
}
