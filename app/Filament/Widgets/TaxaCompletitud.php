<?php

namespace App\Filament\Widgets;

use App\Models\Estadistica;
use App\Models\Peca;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TaxaCompletitud extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        // Visitants unics dels ultims 30 dies amb visitor_id
        $visitantsData = Estadistica::query()
            ->select('visitor_id')
            ->selectRaw('COUNT(DISTINCT peca_id) as peces_vistes')
            ->whereNotNull('visitor_id')
            ->whereNotNull('peca_id')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('visitor_id')
            ->having('peces_vistes', '>=', 2)
            ->get();

        $totalPecesActives = Peca::activa()->count();
        $mitjana = $visitantsData->count() > 0
            ? round($visitantsData->avg('peces_vistes'), 1)
            : 0;

        $percentatge = $totalPecesActives > 0
            ? round(($mitjana / $totalPecesActives) * 100)
            : 0;

        $visitantsUnics = Estadistica::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->whereNotNull('visitor_id')
            ->distinct('visitor_id')
            ->count('visitor_id');

        $visitantsQr = Estadistica::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->whereNotNull('visitor_id')
            ->where('tipus', 'qr_scan')
            ->distinct('visitor_id')
            ->count('visitor_id');

        return [
            Stat::make('Visitants unics (30 dies)', $visitantsUnics)
                ->description($visitantsQr . ' via QR')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Mitjana peces visitades', $mitjana . '/' . $totalPecesActives)
                ->description($percentatge . '% del recorregut')
                ->descriptionIcon('heroicon-m-map')
                ->color($percentatge >= 50 ? 'success' : 'warning'),

            Stat::make('Visitants amb recorregut', $visitantsData->count())
                ->description('Han vist 2+ peces')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
        ];
    }
}
