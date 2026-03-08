<?php

namespace App\Filament\Resources\RedireccioResource\Pages;

use App\Filament\Resources\RedireccioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRedireccio extends EditRecord
{
    protected static string $resource = RedireccioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
