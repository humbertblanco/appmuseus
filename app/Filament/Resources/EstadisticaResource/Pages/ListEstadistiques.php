<?php

namespace App\Filament\Resources\EstadisticaResource\Pages;

use App\Filament\Pages\ExportarEstadistiques;
use App\Filament\Resources\EstadisticaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstadistiques extends ListRecords
{
    protected static string $resource = EstadisticaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('exportar')
                ->label('Exportar')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(ExportarEstadistiques::getUrl())
                ->color('gray'),
        ];
    }
}
