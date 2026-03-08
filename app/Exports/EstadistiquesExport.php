<?php

namespace App\Exports;

use App\Models\Estadistica;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EstadistiquesExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected string $dataInici;
    protected string $dataFi;
    protected ?int $exposicioId;
    protected ?string $tipus;
    protected ?string $idioma;
    protected ?string $dispositiu;

    public function __construct(
        string $dataInici,
        string $dataFi,
        ?int $exposicioId = null,
        ?string $tipus = null,
        ?string $idioma = null,
        ?string $dispositiu = null,
    ) {
        $this->dataInici = $dataInici;
        $this->dataFi = $dataFi;
        $this->exposicioId = $exposicioId;
        $this->tipus = $tipus;
        $this->idioma = $idioma;
        $this->dispositiu = $dispositiu;
    }

    public function query()
    {
        $query = Estadistica::query()
            ->with(['peca.traduccions', 'exposicio.traduccions'])
            ->whereBetween('created_at', [$this->dataInici . ' 00:00:00', $this->dataFi . ' 23:59:59'])
            ->orderBy('created_at', 'desc');

        if ($this->exposicioId) {
            $query->where('exposicio_id', $this->exposicioId);
        }
        if ($this->tipus) {
            $query->where('tipus', $this->tipus);
        }
        if ($this->idioma) {
            $query->where('idioma', $this->idioma);
        }
        if ($this->dispositiu) {
            $query->where('dispositiu', $this->dispositiu);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Data',
            'Hora',
            'Tipus',
            'Idioma',
            'Dispositiu',
            'Exposicio',
            'Peça',
            'Visitant',
            'User Agent',
        ];
    }

    public function map($estadistica): array
    {
        return [
            $estadistica->id,
            $estadistica->created_at->format('d/m/Y'),
            $estadistica->created_at->format('H:i:s'),
            match ($estadistica->tipus) {
                'qr_scan' => 'QR',
                'redireccio' => 'Redireccio',
                default => 'Web',
            },
            $estadistica->idioma ?? '-',
            $estadistica->dispositiu ?? '-',
            $estadistica->exposicio?->traduccio('ca')?->titol ?? '-',
            $estadistica->peca?->traduccio('ca')?->titol ?? '-',
            $estadistica->visitor_id ?? '-',
            $estadistica->user_agent ?? '-',
        ];
    }
}
