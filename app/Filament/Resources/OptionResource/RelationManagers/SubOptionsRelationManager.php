<?php

namespace App\Filament\Resources\OptionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\Concerns\Translatable;

class SubOptionsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'subOptions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label(__('filament.NameInEnglish'))
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('nameInArabic')
                    ->required()
                    ->label(__('filament.NamrInArabic'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('unit')
                    ->required()
                    ->label(__('filament.Unit'))
                    ->maxLength(255),
                
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label(__('filament.Name')),

                Tables\Columns\TextColumn::make('unit')
                ->label(__('filament.Unit')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->using(function (array $data, string  $model)  {
                    
                    return $model::create([
                        'name' => ['ar' => $data['nameInArabic'], 'en' => $data['name']],
                        'option_id' => $this->getOwnerRecord()->id,
                        'unit' => $data['unit'],
                    ]);
                }),
                Tables\Actions\LocaleSwitcher::make(),
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

    public function getTranslatableLocales(): array
    {
        return ['ar', 'en'];
    }
}
