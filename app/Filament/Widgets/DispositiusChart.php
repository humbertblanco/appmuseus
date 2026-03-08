<?php

namespace App\Filament\Widgets;

use App\Models\Estadistica;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DispositiusChart extends ChartWidget
{
    protected static ?string $heading = 'Dispositius';
    protected static ?int $sort = 5;
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
        $query = Estadistica::query()
            ->select('dispositiu', DB::raw('COUNT(*) as total'))
            ->whereNotNull('dispositiu')
            ->groupBy('dispositiu');

        if ($this->filter && $this->filter !== 'all') {
            $query->where('created_at', '>=', now()->subDays((int) $this->filter));
        }

        $counts = $query->pluck('total', 'dispositiu');

        $dispositius = [
            'mobile' => ['label' => 'Mobil', 'color' => '#10b981'],
            'desktop' => ['label' => 'Escriptori', 'color' => '#0ea5e9'],
            'tablet' => ['label' => 'Tauleta', 'color' => '#f59e0b'],
        ];

        $data = [];
        $labels = [];
        $bgColors = [];

        foreach ($dispositius as $code => $info) {
            $count = $counts->get($code, 0);
            if ($count > 0) {
                $data[] = $count;
                $labels[] = $info['label'];
                $bgColors[] = $info['color'];
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
        return 'doughnut';
    }
}
