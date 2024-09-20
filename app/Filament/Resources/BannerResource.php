<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\SelectFilter;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPluralModelLabel(): string
    {
        return __('filament.Banners');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                ->disk('public')
                ->directory('banners')
                ->required()
                ->image()
                ->label(__('filament.Image')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label(__('filament.Image')),
            ])
            ->filters([
                SelectFilter::make('status')
                ->options([
                    1 => 'Active',
                    0 => 'Inactive',
                ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make("toggleActive")
                    ->label(__("filament.ToggleActive"))
                    ->requiresConfirmation()
                    ->action(function (Banner $record) {
                        if($record->is_active == true){
                            $record->is_active =  false;
                        }
                        else{
                            $record->is_active = true ;
                        }
                        $record->save();
                    }),

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
