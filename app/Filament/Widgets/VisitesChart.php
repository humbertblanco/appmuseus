<?php

namespace App\Filament\Widgets;

use App\Models\Estadistica;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VisitesChart extends ChartWidget
{
    protected static ?string $heading = 'Visites per dia';
    protected static ?int $sort = 3;

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '7' => 'Ultims 7 dies',
            '30' => 'Ultims 30 dies',
            '90' => 'Ultims 90 dies',
        ];
    }

    protected function getData(): array
    {
        $days = (int) ($this->filter ?? 30);

        $dates = collect();
        for ($i = $days - 1; $i >= 0; $i--) {
            $dates->push(Carbon::today()->subDays($i)->format('Y-m-d'));
        }

        $stats = Estadistica::query()
            ->select(
                DB::raw('DATE(created_at) as dia'),
                DB::raw("SUM(CASE WHEN tipus = 'qr_scan' THEN 1 ELSE 0 END) as qr"),
                DB::raw("SUM(CASE WHEN tipus = 'visita' THEN 1 ELSE 0 END) as web"),
                DB::raw("SUM(CASE WHEN tipus = 'redireccio' THEN 1 ELSE 0 END) as redir"),
            )
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('dia')
            ->get()
            ->keyBy('dia');

        $qrData = $dates->map(fn ($d) => $stats->get($d)?->qr ?? 0)->toArray();
        $webData = $dates->map(fn ($d) => $stats->get($d)?->web ?? 0)->toArray();
        $redirData = $dates->map(fn ($d) => $stats->get($d)?->redir ?? 0)->toArray();

        $labelFormat = $days > 30 ? 'd/m' : 'd/m';
        $labels = $dates->map(fn ($d) => Carbon::parse($d)->format($labelFormat))->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'QR Scans',
                    'data' => $qrData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Visites web',
                    'data' => $webData,
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => 'rgba(14, 165, 233, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Redireccions',
                    'data' => $redirData,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
