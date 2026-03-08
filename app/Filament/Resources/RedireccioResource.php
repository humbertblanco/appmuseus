<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedireccioResource\Pages;
use App\Models\Redireccio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RedireccioResource extends Resource
{
    protected static ?string $model = Redireccio::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-right';
    protected static ?string $navigationLabel = 'Redireccions';
    protected static ?string $modelLabel = 'Redirecció';
    protected static ?string $pluralModelLabel = 'Redireccions';
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationGroup = 'Configuració';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('origen')
                            ->label('URL origen')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Path sense domini, p.ex: /antiga-pagina'),

                        Forms\Components\TextInput::make('desti')
                            ->label('URL destí')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Path nou, p.ex: /ca/peca/nova-pagina'),

                        Forms\Components\Select::make('tipus')
                            ->label('Tipus de redirecció')
                            ->options([
                                301 => '301 - Permanent',
                                302 => '302 - Temporal',
                            ])
                            ->default(301)
                            ->required(),

                        Forms\Components\Toggle::make('activa')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('origen')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('desti')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('tipus')
                    ->colors([
                        'success' => 301,
                        'warning' => 302,
                    ]),

                Tables\Columns\IconColumn::make('activa')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activa'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedireccions::route('/'),
            'create' => Pages\CreateRedireccio::route('/create'),
            'edit' => Pages\EditRedireccio::route('/{record}/edit'),
        ];
    }
}
