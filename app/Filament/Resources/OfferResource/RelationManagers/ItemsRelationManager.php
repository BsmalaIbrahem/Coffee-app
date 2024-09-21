<?php

namespace App\Filament\Resources\OfferResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;
use App\Models\OfferedItem;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Create New Offer')
                ->tabs([
                    
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

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('type'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->using(function (array $data, string  $model)  {

                    if(!$this->getOwnerRecord()->is_global){
                        foreach($data['categories'] as $category_id){
                            $offer_item = new OfferedItem(['offer_id' => $this->getOwnerRecord()->id]);
                            $category =  \App\Models\Category::find($category_id);
                            $category->offers()->save($offer_item);
                        }
            
                        foreach($data['products'] as $product_id){
                            $offer_item = new OfferedItem(['offer_id' => $this->getOwnerRecord()->id]);
                            $product =  \App\Models\Product::find($product_id);
                            $product->offers()->save($offer_item);
                        }
                    }
                    return $offer_item;
            
                }),

            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
