<?php

namespace App\Filament\Resources\RedireccioResource\Pages;

use App\Filament\Resources\RedireccioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRedireccions extends ListRecords
{
    protected static string $resource = RedireccioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
