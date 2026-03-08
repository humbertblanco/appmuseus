<?php

namespace App\Filament\Resources\ExposicioResource\Pages;

use App\Filament\Resources\ExposicioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExposicions extends ListRecords
{
    protected static string $resource = ExposicioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
