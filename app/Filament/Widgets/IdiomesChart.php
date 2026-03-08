<?php

namespace App\Filament\Widgets;

use App\Models\Estadistica;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class IdiomesChart extends ChartWidget
{
    protected static ?string $heading = 'Visites per idioma';
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 1;

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
        $idiomes = [
            'ca' => 'Catala',
            'es' => 'Castella',
            'en' => 'Angles',
            'fr' => 'Frances',
        ];

        $colors = [
            'ca' => '#0ea5e9',
            'es' => '#f59e0b',
            'en' => '#10b981',
            'fr' => '#ef4444',
        ];

        $query = Estadistica::query()
            ->select('idioma', DB::raw('COUNT(*) as total'))
            ->whereNotNull('idioma')
            ->groupBy('idioma');

        if ($this->filter && $this->filter !== 'all') {
            $query->where('created_at', '>=', now()->subDays((int) $this->filter));
        }

        $counts = $query->pluck('total', 'idioma');

        $data = [];
        $labels = [];
        $bgColors = [];

        foreach ($idiomes as $code => $name) {
            $count = $counts->get($code, 0);
            if ($count > 0) {
                $data[] = $count;
                $labels[] = $name;
                $bgColors[] = $colors[$code];
            }
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => $bgColors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
