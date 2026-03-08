<?php

namespace App\Filament\Resources\ExposicioResource\Pages;

use App\Filament\Resources\ExposicioResource;
use App\Models\Exposicio;
use App\Models\ExposicioDocument;
use App\Models\ExposicioTraduccio;
use Filament\Resources\Pages\CreateRecord;

class CreateExposicio extends CreateRecord
{
    protected static string $resource = ExposicioResource::class;

    protected array $traduccionsData = [];
    protected array $documentsData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->traduccionsData = $data['traduccions'] ?? [];
        $this->documentsData = $data['documents_data'] ?? [];

        unset($data['traduccions'], $data['documents_data']);

        if (empty($data['ordre']) || $data['ordre'] == 0) {
            $data['ordre'] = Exposicio::max('ordre') + 1;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Crear traduccions
        foreach ($this->traduccionsData as $idioma => $traduccio) {
            if (!empty($traduccio['titol'])) {
                ExposicioTraduccio::create([
                    'exposicio_id' => $this->record->id,
                    'idioma' => $idioma,
                    'titol' => $traduccio['titol'] ?? '',
                    'descripcio' => $traduccio['descripcio'] ?? null,
                    'adreca' => $traduccio['adreca'] ?? null,
                    'telefon' => $traduccio['telefon'] ?? null,
                    'email' => $traduccio['email'] ?? null,
                    'web_url' => $traduccio['web_url'] ?? null,
                    'facebook_url' => $traduccio['facebook_url'] ?? null,
                    'instagram_url' => $traduccio['instagram_url'] ?? null,
                ]);
            }
        }

        // Crear documents
        foreach ($this->documentsData as $doc) {
            if (!empty($doc['fitxer']) && !empty($doc['titol'])) {
                ExposicioDocument::create([
                    'exposicio_id' => $this->record->id,
                    'idioma' => $doc['idioma'],
                    'titol' => $doc['titol'],
                    'descripcio' => $doc['descripcio'] ?? null,
                    'fitxer' => $doc['fitxer'],
                    'ordre' => $doc['ordre'] ?? 0,
                    'actiu' => $doc['actiu'] ?? true,
                ]);
            }
        }
    }
}
