<?php

namespace App\Filament\Pages;

use App\Exports\EstadistiquesExport;
use App\Models\Estadistica;
use App\Models\Exposicio;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Maatwebsite\Excel\Facades\Excel;

class ExportarEstadistiques extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationLabel = 'Exportar';
    protected static ?string $title = 'Exportar Estadistiques';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationGroup = 'Estadistiques';

    protected static string $view = 'filament.pages.exportar-estadistiques';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'data_inici' => now()->subMonth()->format('Y-m-d'),
            'data_fi' => now()->format('Y-m-d'),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Periode')
                    ->schema([
                        Forms\Components\DatePicker::make('data_inici')
                            ->label('Data inici')
                            ->required()
                            ->live(),

                        Forms\Components\DatePicker::make('data_fi')
                            ->label('Data fi')
                            ->required()
                            ->live(),

                        Forms\Components\Select::make('format')
                            ->label('Format')
                            ->options([
                                'xlsx' => 'Excel (.xlsx)',
                                'csv' => 'CSV (.csv)',
                            ])
                            ->default('xlsx')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Filtres opcionals')
                    ->schema([
                        Forms\Components\Select::make('exposicio_id')
                            ->label('Exposicio')
                            ->options(Exposicio::all()->mapWithKeys(fn ($e) => [$e->id => $e->traduccio('ca')?->titol ?? $e->slug]))
                            ->searchable()
                            ->placeholder('Totes')
                            ->live(),

                        Forms\Components\Select::make('tipus')
                            ->label('Tipus')
                            ->options([
                                'qr_scan' => 'QR Scan',
                                'visita' => 'Visita web',
                                'redireccio' => 'Redireccio',
                            ])
                            ->placeholder('Tots')
                            ->live(),

                        Forms\Components\Select::make('idioma')
                            ->label('Idioma')
                            ->options([
                                'ca' => 'Catala',
                                'es' => 'Castella',
                                'en' => 'Angles',
                                'fr' => 'Frances',
                            ])
                            ->placeholder('Tots')
                            ->live(),

                        Forms\Components\Select::make('dispositiu')
                            ->label('Dispositiu')
                            ->options([
                                'mobile' => 'Mobil',
                                'tablet' => 'Tauleta',
                                'desktop' => 'Escriptori',
                            ])
                            ->placeholder('Tots')
                            ->live(),
                    ])->columns(4),
            ])
            ->statePath('data');
    }

    public function getRecordCount(): int
    {
        $data = $this->data;

        if (empty($data['data_inici']) || empty($data['data_fi'])) {
            return 0;
        }

        $query = Estadistica::query()
            ->whereBetween('created_at', [$data['data_inici'] . ' 00:00:00', $data['data_fi'] . ' 23:59:59']);

        if (! empty($data['exposicio_id'])) {
            $query->where('exposicio_id', $data['exposicio_id']);
        }
        if (! empty($data['tipus'])) {
            $query->where('tipus', $data['tipus']);
        }
        if (! empty($data['idioma'])) {
            $query->where('idioma', $data['idioma']);
        }
        if (! empty($data['dispositiu'])) {
            $query->where('dispositiu', $data['dispositiu']);
        }

        return $query->count();
    }

    public function export()
    {
        $data = $this->form->getState();

        $filename = 'estadistiques_' . $data['data_inici'] . '_' . $data['data_fi'] . '.' . $data['format'];

        Notification::make()
            ->title('Exportacio iniciada')
            ->success()
            ->send();

        return Excel::download(
            new EstadistiquesExport(
                $data['data_inici'],
                $data['data_fi'],
                $data['exposicio_id'] ?? null,
                $data['tipus'] ?? null,
                $data['idioma'] ?? null,
                $data['dispositiu'] ?? null,
            ),
            $filename
        );
    }
}
