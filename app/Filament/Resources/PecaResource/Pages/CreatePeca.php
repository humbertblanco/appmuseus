<?php

namespace App\Filament\Resources\PecaResource\Pages;

use App\Filament\Resources\PecaResource;
use App\Models\Peca;
use App\Models\PecaImatge;
use App\Models\PecaMaterial;
use App\Models\PecaTraduccio;
use Filament\Resources\Pages\CreateRecord;

class CreatePeca extends CreateRecord
{
    protected static string $resource = PecaResource::class;

    protected array $traduccionsData = [];
    protected array $imatgesGaleria = [];
    protected array $materialsData = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->traduccionsData = $data['traduccions'] ?? [];
        $this->imatgesGaleria = $data['imatges_galeria'] ?? [];
        $this->materialsData = $data['materials_data'] ?? [];

        unset($data['traduccions'], $data['imatges_galeria'], $data['materials_data']);

        if (empty($data['ordre']) || $data['ordre'] == 0) {
            $data['ordre'] = Peca::where('exposicio_id', $data['exposicio_id'])->max('ordre') + 1;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Crear traduccions
        foreach ($this->traduccionsData as $idioma => $traduccio) {
            if (!empty($traduccio['titol'])) {
                PecaTraduccio::create([
                    'peca_id' => $this->record->id,
                    'idioma' => $idioma,
                    'titol' => $traduccio['titol'] ?? '',
                    'subtitol' => $traduccio['subtitol'] ?? null,
                    'periode' => $traduccio['periode'] ?? null,
                    'descripcio' => $traduccio['descripcio'] ?? null,
                    'audio_url' => $traduccio['audio_url'] ?? null,
                    'audio_descripcio_url' => $traduccio['audio_descripcio_url'] ?? null,
                    'text_audiodescripcio' => $traduccio['text_audiodescripcio'] ?? null,
                ]);
            }
        }

        // Crear imatges
        foreach ($this->imatgesGaleria as $index => $url) {
            if (!empty($url)) {
                PecaImatge::create([
                    'peca_id' => $this->record->id,
                    'url' => $url,
                    'alt_text' => null,
                    'ordre' => $index,
                ]);
            }
        }

        // Crear materials
        foreach ($this->materialsData as $material) {
            // Determinar la URL: si és PDF, usar el fitxer pujat; sinó, usar la URL externa
            $url = $material['tipus'] === 'pdf'
                ? ($material['fitxer'] ?? null)
                : ($material['url'] ?? null);

            if (!empty($url) && !empty($material['titol'])) {
                PecaMaterial::create([
                    'peca_id' => $this->record->id,
                    'idioma' => $material['idioma'],
                    'tipus' => $material['tipus'],
                    'titol' => $material['titol'],
                    'url' => $url,
                ]);
            }
        }
    }
}
