<?php

namespace App\Filament\Resources\ExposicioResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PecesRelationManager extends RelationManager
{
    protected static string $relationship = 'peces';
    protected static ?string $title = 'Sales / Peces';
    protected static ?string $recordTitleAttribute = 'slug';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('primera_imatge')
                    ->label('')
                    ->getStateUsing(fn ($record) => $record->imatges->first()?->url)
                    ->disk('public')
                    ->size(40)
                    ->circular(),

                Tables\Columns\TextColumn::make('ordre')
                    ->label('#')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('titol_ca')
                    ->label('Títol')
                    ->getStateUsing(fn ($record) => $record->traduccio('ca')?->titol ?? $record->slug)
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('URL')
                    ->color('gray')
                    ->size('sm'),

                Tables\Columns\IconColumn::make('te_audio_ad')
                    ->label('AD')
                    ->tooltip('Audiodescripció (cecs)')
                    ->getStateUsing(fn ($record) => $record->traduccions->contains(fn ($t) => !empty($t->audio_descripcio_url)))
                    ->boolean()
                    ->trueIcon('heroicon-o-speaker-wave')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('te_transcripcio')
                    ->label('TXT')
                    ->tooltip('Transcripció (sords)')
                    ->getStateUsing(fn ($record) => $record->traduccions->contains(fn ($t) => !empty($t->text_audiodescripcio)))
                    ->boolean()
                    ->trueIcon('heroicon-o-document-text')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('activa')
                    ->label('Visible')
                    ->boolean()
                    ->alignCenter(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activa')
                    ->label('Visible'),
            ])
            ->headerActions([
                Tables\Actions\Action::make('create')
                    ->label('Nova peça')
                    ->icon('heroicon-o-plus')
                    ->url(fn () => route('filament.admin.resources.pecas.create') . '?exposicio_id=' . $this->getOwnerRecord()->id),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Editar')
                    ->icon('heroicon-o-pencil')
                    ->url(fn ($record) => route('filament.admin.resources.pecas.edit', $record)),
                Tables\Actions\Action::make('qr')
                    ->label('QR')
                    ->icon('heroicon-o-qr-code')
                    ->url(fn ($record) => route('filament.admin.resources.pecas.qr', $record))
                    ->openUrlInNewTab(),
            ])
            ->reorderable('ordre')
            ->defaultSort('ordre');
    }
}
