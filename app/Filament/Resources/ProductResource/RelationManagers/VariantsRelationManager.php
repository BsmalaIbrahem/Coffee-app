<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Repeater;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('Variants')
                ->schema([
                    Tabs::make()->tabs([
                        Tabs\Tab::make('Options')->schema([
                            Repeater::make('Options')->schema([
                                Forms\Components\Select::make('option')
                                    ->options(\App\Models\Option::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->afterStateUpdated(fn (Set $set) => $set('sub_option', null)),

                                Forms\Components\Select::make('sub_option')
                                ->label(__('filament.SubOption'))
                                ->required()
                                ->preload()
                                ->searchable()
                                ->options(fn (Get $get) => \App\Models\SubOption::query()->where('option_id', $get('option'))->pluck('name', 'id')),
                        
                            ]),
                            Forms\Components\TextInput::make('price')
                                ->numeric()
                                ->required()
                                ->label(__('filament.Price')),

                            Forms\Components\TextInput::make('quantity')
                                ->numeric()
                                ->default(0)
                                ->label(__('filament.Quantity')),

                            Forms\Components\Toggle::make('is_same_price')
                                ->label(__('filament.is_same_price'))
                                ->onIcon('heroicon-m-bolt')
                                ->offIcon('heroicon-m-user'),
                        ]),
                    ])
                    ->columnSpan('full')
                ])->columnSpan('full')

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('sub_options_names')
                    ->label(__('filament.SubOptions'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label(__('filament.Price')),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('filament.Quantity')),

                Tables\Columns\IconColumn::make('is_same_price')
                    ->boolean()
                    ->label(__('filament.is_same_price')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->using(function (array $data, string  $model)  {
                    foreach($data['Variants'] as $variant){
                        $sub_options=[];
                        foreach($variant['Options'] as $option){
                            array_push($sub_options, (int)$option['sub_option']);
                        }

                         $m = $model::create([
                            'product_id' => $this->getOwnerRecord()->id,
                            'sub_options_ids' => json_encode($sub_options),
                            'quantity' => $variant['quantity'],
                            'price' => $variant['price'],
                            'is_same_price' => $variant['is_same_price']
                        ]);
                    }
                    return $m;
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
            ]);
    }
}