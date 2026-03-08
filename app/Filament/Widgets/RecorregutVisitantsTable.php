<?php

namespace App\Filament\Widgets;

use App\Models\Estadistica;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;

class RecorregutVisitantsTable extends BaseWidget
{
    protected static ?string $heading = 'Ultims visitants i recorregut';
    protected static ?int $sort = 8;
    protected int|string|array $columnSpan = 'full';

    public function getTableRecordKey($record): string
    {
        return (string) ($record->visitor_id ?? $record->ip_hash);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Estadistica::query()
                    ->select(DB::raw('COALESCE(visitor_id, ip_hash) as visitor_key'))
                    ->selectRaw('MIN(visitor_id) as visitor_id')
                    ->selectRaw('MIN(ip_hash) as ip_hash')
                    ->selectRaw('MIN(created_at) as primera_visita')
                    ->selectRaw('MAX(created_at) as ultima_visita')
                    ->selectRaw('COUNT(*) as total_pagines')
                    ->selectRaw('COUNT(DISTINCT peca_id) as peces_vistes')
                    ->selectRaw('MAX(idioma) as idioma')
                    ->selectRaw('MAX(dispositiu) as dispositiu')
                    ->selectRaw("SUM(CASE WHEN tipus = 'qr_scan' THEN 1 ELSE 0 END) as qr_scans")
                    ->where(function ($q) {
                        $q->whereNotNull('visitor_id')->orWhereNotNull('ip_hash');
                    })
                    ->where('created_at', '>=', now()->subDays(7))
                    ->groupBy('visitor_key')
                    ->orderByDesc('ultima_visita')
                    ->limit(20)
            )
            ->columns([
                Tables\Columns\TextColumn::make('primera_visita')
                    ->label('Quan')
                    ->formatStateUsing(function ($state) {
                        $dt = Carbon::parse($state);
                        return $dt->diffForHumans();
                    })
                    ->description(fn ($record) => Carbon::parse($record->primera_visita)->format('d/m H:i'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('idioma')
                    ->label('Idioma')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'ca' => 'primary',
                        'es' => 'warning',
                        'en' => 'success',
                        'fr' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('dispositiu')
                    ->label('Dispositiu')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'mobile' => 'Mobil',
                        'tablet' => 'Tauleta',
                        'desktop' => 'PC',
                        default => '-',
                    })
                    ->color(fn ($state) => match ($state) {
                        'mobile' => 'success',
                        'tablet' => 'warning',
                        'desktop' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('recorregut')
                    ->label('Recorregut')
                    ->getStateUsing(function ($record) {
                        $query = Estadistica::query()
                            ->where('created_at', '>=', now()->subDays(7))
                            ->whereNotNull('peca_id')
                            ->orderBy('created_at')
                            ->with('peca.traduccions');

                        if ($record->visitor_id) {
                            $query->where('visitor_id', $record->visitor_id);
                        } else {
                            $query->where('ip_hash', $record->ip_hash);
                        }

                        $peces = $query->get()
                            ->map(fn ($v) => $v->peca?->traduccio('ca')?->titol ?? $v->peca?->slug)
                            ->filter()
                            ->unique()
                            ->values();

                        if ($peces->isEmpty()) {
                            return '-';
                        }

                        $badges = $peces->map(function ($nom, $i) {
                            $colors = ['bg-blue-100 text-blue-800', 'bg-green-100 text-green-800', 'bg-purple-100 text-purple-800', 'bg-amber-100 text-amber-800', 'bg-rose-100 text-rose-800'];
                            $color = $colors[$i % count($colors)];
                            return '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ' . $color . '">' . e($nom) . '</span>';
                        });

                        return new HtmlString($badges->implode('<span class="text-gray-400 mx-1">&rarr;</span>'));
                    })
                    ->html()
                    ->wrap(),

                Tables\Columns\IconColumn::make('via_qr')
                    ->label('QR')
                    ->getStateUsing(fn ($record) => $record->qr_scans > 0)
                    ->boolean()
                    ->trueIcon('heroicon-o-qr-code')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('peces_vistes')
                    ->label('Peces')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_pagines')
                    ->label('Total')
                    ->weight('bold')
                    ->alignCenter(),
            ]);
    }
}
