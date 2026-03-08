<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstadisticaResource\Pages;
use App\Models\Estadistica;
use App\Models\Exposicio;
use App\Models\Peca;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EstadisticaResource extends Resource
{
    protected static ?string $model = Estadistica::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Estadistiques';
    protected static ?string $modelLabel = 'Estadistica';
    protected static ?string $pluralModelLabel = 'Estadistiques';
    protected static ?string $navigationGroup = 'Estadistiques';
    protected static ?int $navigationSort = 10;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('titol')
                    ->label('Pagina')
                    ->getStateUsing(function ($record) {
                        if ($record->peca_id && $record->peca) {
                            return $record->peca->traduccio('ca')?->titol ?? $record->peca->slug;
                        }
                        if ($record->exposicio_id && $record->exposicio) {
                            return $record->exposicio->traduccio('ca')?->titol ?? $record->exposicio->slug;
                        }
                        return 'Home';
                    })
                    ->description(function ($record) {
                        if ($record->peca_id && $record->peca) {
                            return $record->peca->exposicio?->traduccio('ca')?->titol;
                        }
                        return null;
                    })
                    ->searchable(query: function ($query, string $search) {
                        return $query->where(function ($q) use ($search) {
                            $q->whereHas('peca', fn ($p) => $p->where('slug', 'like', "%{$search}%"))
                              ->orWhereHas('peca.traduccions', fn ($t) => $t->where('titol', 'like', "%{$search}%"))
                              ->orWhereHas('exposicio', fn ($e) => $e->where('slug', 'like', "%{$search}%"));
                        });
                    }),

                Tables\Columns\TextColumn::make('tipus')
                    ->label('Tipus')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'qr_scan' => 'success',
                        'redireccio' => 'warning',
                        default => 'info',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'qr_scan' => 'QR',
                        'redireccio' => 'Redir',
                        default => 'Web',
                    }),

                Tables\Columns\TextColumn::make('idioma')
                    ->label('Idioma')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'ca' => 'CA',
                        'es' => 'ES',
                        'en' => 'EN',
                        'fr' => 'FR',
                        default => $state,
                    })
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

                Tables\Columns\TextColumn::make('visitor_id')
                    ->label('Visitant')
                    ->limit(8)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tipus')
                    ->label('Tipus')
                    ->options([
                        'qr_scan' => 'QR Scan',
                        'visita' => 'Visita web',
                        'redireccio' => 'Redireccio',
                    ]),

                Tables\Filters\SelectFilter::make('idioma')
                    ->label('Idioma')
                    ->options([
                        'ca' => 'Catala',
                        'es' => 'Castella',
                        'en' => 'Angles',
                        'fr' => 'Frances',
                    ]),

                Tables\Filters\SelectFilter::make('dispositiu')
                    ->label('Dispositiu')
                    ->options([
                        'mobile' => 'Mobil',
                        'tablet' => 'Tauleta',
                        'desktop' => 'Escriptori',
                    ]),

                Tables\Filters\SelectFilter::make('exposicio_id')
                    ->label('Exposicio')
                    ->options(Exposicio::all()->mapWithKeys(fn ($e) => [$e->id => $e->traduccio('ca')?->titol ?? $e->slug]))
                    ->searchable(),

                Tables\Filters\SelectFilter::make('peca_id')
                    ->label('Peça')
                    ->options(Peca::all()->mapWithKeys(fn ($p) => [$p->id => $p->traduccio('ca')?->titol ?? $p->slug]))
                    ->searchable(),
            ])
            ->filtersFormColumns(5)
            ->actions([])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('30s');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstadistiques::route('/'),
        ];
    }
}
