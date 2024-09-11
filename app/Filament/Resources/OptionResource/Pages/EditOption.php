<?php

namespace App\Filament\Resources\OptionResource\Pages;

use App\Filament\Resources\OptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOption extends EditRecord
{
    use EditRecord\Concerns\Translatable;
    
    protected static string $resource = OptionResource::class;

    public function getTitle(): string
    {
        return __('filament.EditOption');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
