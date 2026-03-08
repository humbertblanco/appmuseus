<?php

namespace App\Filament\Resources\ExposicioResource\Pages;

use App\Filament\Resources\ExposicioResource;
use App\Models\Exposicio;
use Filament\Resources\Pages\Page;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrExposicio extends Page
{
    protected static string $resource = ExposicioResource::class;
    protected static string $view = 'filament.resources.exposicio-resource.pages.qr-exposicio';

    public Exposicio $record;

    public function mount(Exposicio $record): void
    {
        $this->record = $record;
    }

    public function getTitle(): string
    {
        return 'QR - ' . ($this->record->traduccio('ca')?->titol ?? $this->record->slug);
    }

    public function getQrSvgForIdioma(string $idioma): string
    {
        $url = route('exposicio.show', ['idioma' => $idioma, 'slug' => $this->record->slug]);
        return QrCode::format('svg')
            ->size(200)
            ->margin(1)
            ->generate($url);
    }

    public function getQrUrlForIdioma(string $idioma): string
    {
        return route('exposicio.show', ['idioma' => $idioma, 'slug' => $this->record->slug]);
    }

    public function downloadPng(string $idioma = 'ca')
    {
        $url = route('exposicio.show', ['idioma' => $idioma, 'slug' => $this->record->slug]);
        $png = QrCode::format('png')
            ->size(500)
            ->margin(2)
            ->generate($url);

        return response()->streamDownload(function () use ($png, $idioma) {
            echo $png;
        }, 'qr-' . $this->record->slug . '-' . $idioma . '.png', [
            'Content-Type' => 'image/png',
        ]);
    }
}
