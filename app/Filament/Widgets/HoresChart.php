<?php

namespace App\Filament\Widgets;

use App\Models\Estadistica;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class HoresChart extends ChartWidget
{
    protected static ?string $heading = 'Hores punta';
    protected static ?int $sort = 6;

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => '7 dies',
            '30' => '30 dies',
            '90' => '90 dies',
            'all' => 'Tot',
        ];
    }

    protected function getData(): array
    {
        $query = Estadistica::query()
            ->select(DB::raw('HOUR(created_at) as hora'), DB::raw('COUNT(*) as total'))
            ->groupBy('hora');

        if ($this->filter && $this->filter !== 'all') {
            $query->where('created_at', '>=', now()->subDays((int) $this->filter));
        }

        $counts = $query->pluck('total', 'hora');

        $data = [];
        $labels = [];

        for ($h = 8; $h <= 21; $h++) {
            $labels[] = sprintf('%02d:00', $h);
            $data[] = $counts->get($h, 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Visites',
                    'data' => $data,
                    'backgroundColor' => '#6366f1',
                    'borderColor' => '#4f46e5',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
