<?php

namespace App\Filament\Widgets;

use App\Models\Estadistica;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class EstadistiquesOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Sparkline data (last 7 days)
        $sparkDays = collect();
        for ($i = 6; $i >= 0; $i--) {
            $sparkDays->push(Carbon::today()->subDays($i)->format('Y-m-d'));
        }

        $dailyStats = Estadistica::query()
            ->select(
                DB::raw('DATE(created_at) as dia'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT visitor_id) as unics'),
                DB::raw("SUM(CASE WHEN tipus = 'qr_scan' THEN 1 ELSE 0 END) as qr"),
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('dia')
            ->get()
            ->keyBy('dia');

        $sparkVisites = $sparkDays->map(fn ($d) => $dailyStats->get($d)?->total ?? 0)->toArray();
        $sparkUnics = $sparkDays->map(fn ($d) => $dailyStats->get($d)?->unics ?? 0)->toArray();
        $sparkQr = $sparkDays->map(fn ($d) => $dailyStats->get($d)?->qr ?? 0)->toArray();

        // Totals
        $totalVisites = Estadistica::count();
        $totalUnics = Estadistica::whereNotNull('visitor_id')->distinct('visitor_id')->count('visitor_id');
        $totalQr = Estadistica::qrScans()->count();

        // Week totals
        $setmanaVisites = Estadistica::where('created_at', '>=', now()->subWeek())->count();
        $setmanaUnics = Estadistica::where('created_at', '>=', now()->subWeek())
            ->whereNotNull('visitor_id')
            ->distinct('visitor_id')
            ->count('visitor_id');
        $setmanaQr = Estadistica::qrScans()->where('created_at', '>=', now()->subWeek())->count();

        return [
            Stat::make('Visites totals', number_format($totalVisites))
                ->description($setmanaVisites . ' ultima setmana')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success')
                ->chart($sparkVisites),

            Stat::make('Visitants unics', number_format($totalUnics))
                ->description($setmanaUnics . ' ultima setmana')
                ->descriptionIcon('heroicon-m-users')
                ->color('info')
                ->chart($sparkUnics),

            Stat::make('Via QR', number_format($totalQr))
                ->description($setmanaQr . ' ultima setmana')
                ->descriptionIcon('heroicon-m-qr-code')
                ->color('warning')
                ->chart($sparkQr),
        ];
    }
}
