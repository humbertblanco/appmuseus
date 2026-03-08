<?php

namespace App\Filament\Widgets;

use App\Models\Estadistica;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopPecesTable extends BaseWidget
{
    protected static ?string $heading = 'Peces més visitades';
    protected static ?int $sort = 7;
    protected int|string|array $columnSpan = 'full';

    public function getTableRecordKey($record): string
    {
        return (string) $record->peca_id;
    }

    public function table(Table $table): Table
    {
        $maxVisites = Estadistica::query()
            ->select(DB::raw('COUNT(*) as total'))
            ->whereNotNull('peca_id')
            ->groupBy('peca_id')
            ->orderByDesc('total')
            ->limit(1)
            ->value('total') ?? 1;

        return $table
            ->query(
                Estadistica::query()
                    ->select('peca_id')
                    ->selectRaw('COUNT(*) as visites')
                    ->selectRaw("SUM(CASE WHEN tipus = 'qr_scan' THEN 1 ELSE 0 END) as qr_scans")
                    ->selectRaw("SUM(CASE WHEN tipus = 'visita' THEN 1 ELSE 0 END) as visites_directes")
                    ->selectRaw('COUNT(DISTINCT visitor_id) as visitants_unics')
                    ->whereNotNull('peca_id')
                    ->groupBy('peca_id')
                    ->orderByDesc('visites')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('peca.slug')
                    ->label('Peça'),

                Tables\Columns\TextColumn::make('peca')
                    ->label('Titol')
                    ->getStateUsing(fn ($record) => $record->peca?->traduccio('ca')?->titol ?? '-'),

                Tables\Columns\TextColumn::make('peca.exposicio')
                    ->label('Exposicio')
                    ->getStateUsing(fn ($record) => $record->peca?->exposicio?->traduccio('ca')?->titol ?? '-'),

                Tables\Columns\TextColumn::make('qr_scans')
                    ->label('QR')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('visites_directes')
                    ->label('Web')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('visitants_unics')
                    ->label('Unics')
                    ->alignCenter()
                    ->color('success'),

                Tables\Columns\TextColumn::make('visites')
                    ->label('Total')
                    ->sortable()
                    ->weight('bold')
                    ->alignCenter()
                    ->formatStateUsing(function ($state) use ($maxVisites) {
                        $pct = $maxVisites > 0 ? round(($state / $maxVisites) * 100) : 0;
                        return view('filament.columns.progress-bar', [
                            'value' => $state,
                            'percentage' => $pct,
                        ])->render();
                    })
                    ->html(),
            ]);
    }
}
