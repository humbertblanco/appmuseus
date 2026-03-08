<?php

namespace App\Filament\Resources\PecaResource\Pages;

use App\Filament\Resources\PecaResource;
use App\Models\PecaImatge;
use App\Models\PecaMaterial;
use App\Models\PecaTraduccio;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeca extends EditRecord
{
    protected static string $resource = PecaResource::class;

    protected array $traduccionsData = [];
    protected array $imatgesGaleria = [];
    protected array $materialsData = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('visit')
                ->label('Visitar pàgina')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn () => route('peca.show', [
                    'idioma' => 'ca',
                    'exposicio' => $this->record->exposicio->slug,
                    'slug' => $this->record->slug,
                ]))
                ->openUrlInNewTab(),
            Actions\Action::make('qr')
                ->label('Veure QR')
                ->icon('heroicon-o-qr-code')
                ->color('gray')
                ->url(fn () => route('filament.admin.resources.pecas.qr', $this->record))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Carregar traduccions
        $traduccions = $this->record->traduccions->keyBy('idioma')->toArray();
        $data['traduccions'] = [];
        foreach (['ca', 'es', 'en', 'fr'] as $idioma) {
            $data['traduccions'][$idioma] = $traduccions[$idioma] ?? ['idioma' => $idioma];
        }

        // Carregar imatges com array simple d'URLs per la galeria
        $data['imatges_galeria'] = $this->record->imatges->pluck('url')->toArray();

        // Carregar materials
        $data['materials_data'] = $this->record->materials->map(fn ($mat) => [
            'idioma' => $mat->idioma,
            'tipus' => $mat->tipus,
            'titol' => $mat->titol,
            'url' => $mat->tipus !== 'pdf' ? $mat->url : null,
            'fitxer' => $mat->tipus === 'pdf' ? $mat->url : null,
        ])->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->traduccionsData = $data['traduccions'] ?? [];
        $this->imatgesGaleria = $data['imatges_galeria'] ?? [];
        $this->materialsData = $data['materials_data'] ?? [];

        unset($data['traduccions'], $data['imatges_galeria'], $data['materials_data']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Actualitzar traduccions
        foreach ($this->traduccionsData as $idioma => $traduccio) {
            if (!empty($traduccio['titol'])) {
                PecaTraduccio::updateOrCreate(
                    [
                        'peca_id' => $this->record->id,
                        'idioma' => $idioma,
                    ],
                    [
                        'titol' => $traduccio['titol'] ?? '',
                        'subtitol' => $traduccio['subtitol'] ?? null,
                        'periode' => $traduccio['periode'] ?? null,
                        'descripcio' => $traduccio['descripcio'] ?? null,
                        'audio_url' => $traduccio['audio_url'] ?? null,
                        'audio_descripcio_url' => $traduccio['audio_descripcio_url'] ?? null,
                        'text_audiodescripcio' => $traduccio['text_audiodescripcio'] ?? null,
                    ]
                );
            } else {
                PecaTraduccio::where('peca_id', $this->record->id)
                    ->where('idioma', $idioma)
                    ->delete();
            }
        }

        // Actualitzar imatges - esborrar i recrear
        $this->record->imatges()->delete();
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

        // Actualitzar materials - esborrar i recrear
        $this->record->materials()->delete();
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
