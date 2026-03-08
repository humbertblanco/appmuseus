<?php

namespace App\Filament\Resources\ExposicioResource\Pages;

use App\Filament\Resources\ExposicioResource;
use App\Models\ExposicioDocument;
use App\Models\ExposicioTraduccio;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExposicio extends EditRecord
{
    protected static string $resource = ExposicioResource::class;

    protected array $traduccionsData = [];
    protected array $documentsData = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('visit')
                ->label('Visitar pàgina')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn () => route('exposicio.show', [
                    'idioma' => 'ca',
                    'slug' => $this->record->slug,
                ]))
                ->openUrlInNewTab(),
            Actions\Action::make('qr')
                ->label('Veure QR')
                ->icon('heroicon-o-qr-code')
                ->color('gray')
                ->url(fn () => route('filament.admin.resources.exposicios.qr', $this->record))
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

        // Carregar documents
        $data['documents_data'] = $this->record->documents->map(fn ($doc) => [
            'id' => $doc->id,
            'idioma' => $doc->idioma,
            'titol' => $doc->titol,
            'descripcio' => $doc->descripcio,
            'fitxer' => $doc->fitxer,
            'ordre' => $doc->ordre,
            'actiu' => $doc->actiu,
        ])->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->traduccionsData = $data['traduccions'] ?? [];
        $this->documentsData = $data['documents_data'] ?? [];

        unset($data['traduccions'], $data['documents_data']);

        return $data;
    }

    protected function afterSave(): void
    {
        // Actualitzar traduccions
        foreach ($this->traduccionsData as $idioma => $traduccio) {
            if (!empty($traduccio['titol'])) {
                ExposicioTraduccio::updateOrCreate(
                    [
                        'exposicio_id' => $this->record->id,
                        'idioma' => $idioma,
                    ],
                    [
                        'titol' => $traduccio['titol'] ?? '',
                        'descripcio' => $traduccio['descripcio'] ?? null,
                        'adreca' => $traduccio['adreca'] ?? null,
                        'telefon' => $traduccio['telefon'] ?? null,
                        'email' => $traduccio['email'] ?? null,
                        'web_url' => $traduccio['web_url'] ?? null,
                        'facebook_url' => $traduccio['facebook_url'] ?? null,
                        'instagram_url' => $traduccio['instagram_url'] ?? null,
                    ]
                );
            } else {
                ExposicioTraduccio::where('exposicio_id', $this->record->id)
                    ->where('idioma', $idioma)
                    ->delete();
            }
        }

        // Actualitzar documents - esborrar i recrear
        $this->record->documents()->delete();
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
