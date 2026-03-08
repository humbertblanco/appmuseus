<?php

namespace App\Filament\Resources\PecaResource\Pages;

use App\Filament\Resources\PecaResource;
use App\Models\Peca;
use Filament\Resources\Pages\Page;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrPeca extends Page
{
    protected static string $resource = PecaResource::class;
    protected static string $view = 'filament.resources.peca-resource.pages.qr-peca';

    public Peca $record;

    public function mount(Peca $record): void
    {
        $this->record = $record->load('exposicio');
    }

    public function getTitle(): string
    {
        return 'QR - ' . ($this->record->traduccio('ca')?->titol ?? $this->record->slug);
    }

    public function getQrSvgForIdioma(string $idioma): string
    {
        $url = route('peca.show', ['idioma' => $idioma, 'exposicio' => $this->record->exposicio->slug, 'slug' => $this->record->slug]);
        return QrCode::format('svg')
            ->size(200)
            ->margin(1)
            ->generate($url);
    }

    public function getQrUrlForIdioma(string $idioma): string
    {
        return route('peca.show', ['idioma' => $idioma, 'exposicio' => $this->record->exposicio->slug, 'slug' => $this->record->slug]);
    }

    public function getQrSvgForIdiomaAD(string $idioma): string
    {
        $url = route('peca.show', ['idioma' => $idioma, 'exposicio' => $this->record->exposicio->slug, 'slug' => $this->record->slug]) . '?ad=1';
        return QrCode::format('svg')
            ->size(200)
            ->margin(1)
            ->generate($url);
    }

    public function getQrUrlForIdiomaAD(string $idioma): string
    {
        return route('peca.show', ['idioma' => $idioma, 'exposicio' => $this->record->exposicio->slug, 'slug' => $this->record->slug]) . '?ad=1';
    }
}
