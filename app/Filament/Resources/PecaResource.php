<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PecaResource\Pages;
use App\Models\Exposicio;
use App\Models\Peca;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PecaResource extends Resource
{
    protected static ?string $model = Peca::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Sales / Peces';
    protected static ?string $modelLabel = 'Sala / Peça';
    protected static ?string $pluralModelLabel = 'Sales / Peces';
    protected static ?string $navigationGroup = 'Contingut';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informació bàsica')
                    ->schema([
                        Forms\Components\Select::make('exposicio_id')
                            ->label('Exposició')
                            ->options(Exposicio::all()->mapWithKeys(fn ($e) => [$e->id => $e->traduccio('ca')?->titol ?? $e->slug]))
                            ->required()
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set, $state) =>
                                $state ? $set('ordre', (Peca::where('exposicio_id', $state)->max('ordre') ?? 0) + 1) : null
                            ),

                        Forms\Components\TextInput::make('slug')
                            ->label('URL')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Identificador únic per a la URL'),

                        Forms\Components\TextInput::make('ordre')
                            ->numeric()
                            ->default(0)
                            ->unique(ignoreRecord: true, modifyRuleUsing: fn ($rule, $get) => $rule->where('exposicio_id', $get('exposicio_id')))
                            ->validationMessages(['unique' => 'Aquest número d\'ordre ja existeix dins l\'exposició.'])
                            ->helperText('Número únic dins l\'exposició. Escull primer l\'exposició.'),

                        Forms\Components\Toggle::make('activa')
                            ->label('Visible')
                            ->default(true),
                    ])->columns(2),

                Forms\Components\Section::make('Imatges')
                    ->schema([
                        Forms\Components\FileUpload::make('imatges_galeria')
                            ->label('Galeria d\'imatges')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->appendFiles()
                            ->disk('public')
                            ->directory('peces')
                            ->visibility('public')
                            ->imagePreviewHeight('150')
                            ->panelLayout('grid')
                            ->openable()
                            ->downloadable()
                            ->maxSize(5120)
                            ->maxFiles(20)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Tabs::make('Traduccions')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Català')
                            ->schema(static::getTraduccioSchema('ca')),
                        Forms\Components\Tabs\Tab::make('Castellà')
                            ->schema(static::getTraduccioSchema('es')),
                        Forms\Components\Tabs\Tab::make('Anglès')
                            ->schema(static::getTraduccioSchema('en')),
                        Forms\Components\Tabs\Tab::make('Francès')
                            ->schema(static::getTraduccioSchema('fr')),
                    ])->columnSpanFull(),

                Forms\Components\Section::make('Materials addicionals')
                    ->schema([
                        Forms\Components\Repeater::make('materials_data')
                            ->label('Materials')
                            ->schema([
                                Forms\Components\Grid::make(2)->schema([
                                    Forms\Components\Select::make('idioma')
                                        ->options([
                                            'ca' => 'Català',
                                            'es' => 'Castellà',
                                            'en' => 'Anglès',
                                            'fr' => 'Francès',
                                        ])
                                        ->required(),

                                    Forms\Components\Select::make('tipus')
                                        ->options([
                                            'pdf' => 'PDF (pujar fitxer)',
                                            'link' => 'Enllaç extern',
                                            'video' => 'Vídeo',
                                            'signes' => 'Vídeo llengua de signes (Mirada Tàctil)',
                                        ])
                                        ->required()
                                        ->live(),
                                ]),

                                Forms\Components\TextInput::make('titol')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('fitxer')
                                    ->label('Fitxer PDF')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->disk('public')
                                    ->directory('materials')
                                    ->visibility('public')
                                    ->openable()
                                    ->maxSize(20480)
                                    ->columnSpanFull()
                                    ->visible(fn ($get) => $get('tipus') === 'pdf'),

                                Forms\Components\TextInput::make('url')
                                    ->label('URL externa')
                                    ->url()
                                    ->maxLength(500)
                                    ->columnSpanFull()
                                    ->visible(fn ($get) => in_array($get('tipus'), ['link', 'video', 'signes'])),
                            ])
                            ->collapsible()
                            ->collapsed()
                            ->defaultItems(0)
                            ->itemLabel(fn (array $state): ?string => $state['titol'] ?? null),
                    ]),
            ]);
    }

    protected static function getTraduccioSchema(string $idioma): array
    {
        return [
            Forms\Components\Hidden::make("traduccions.{$idioma}.idioma")
                ->default($idioma),

            Forms\Components\TextInput::make("traduccions.{$idioma}.titol")
                ->label('Títol')
                ->maxLength(255),

            Forms\Components\TextInput::make("traduccions.{$idioma}.subtitol")
                ->label('Subtítol (artista, autor...)')
                ->maxLength(255),

            Forms\Components\TextInput::make("traduccions.{$idioma}.periode")
                ->label('Subtítol 2')
                ->maxLength(255),

            Forms\Components\Textarea::make("traduccions.{$idioma}.descripcio")
                ->label('Descripció')
                ->rows(4),

            Forms\Components\FileUpload::make("traduccions.{$idioma}.audio_url")
                ->label('Àudio (MP3)')
                ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'])
                ->disk('public')
                ->directory('audios')
                ->visibility('public')
                ->openable()
                ->downloadable()
                ->maxSize(30720),

            Forms\Components\Section::make('Audiodescripció')
                ->schema([
                    Forms\Components\FileUpload::make("traduccions.{$idioma}.audio_descripcio_url")
                        ->label('Àudio audiodescripció (MP3)')
                        ->acceptedFileTypes(['audio/mpeg', 'audio/mp3', 'audio/wav', 'audio/ogg'])
                        ->disk('public')
                        ->directory('audios')
                        ->visibility('public')
                        ->openable()
                        ->downloadable()
                        ->maxSize(30720),

                    Forms\Components\Textarea::make("traduccions.{$idioma}.text_audiodescripcio")
                        ->label('Text audiodescripció')
                        ->rows(3),
                ])
                ->collapsed(),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('primera_imatge')
                    ->label('')
                    ->getStateUsing(fn ($record) => $record->imatges->first()?->url)
                    ->disk('public')
                    ->size(50)
                    ->circular()
                    ->grow(false),

                Tables\Columns\TextColumn::make('ordre')
                    ->label('#')
                    ->sortable()
                    ->alignCenter()
                    ->grow(false),

                Tables\Columns\TextColumn::make('titol_ca')
                    ->label('Títol')
                    ->getStateUsing(fn ($record) => $record->traduccio('ca')?->titol ?? $record->slug)
                    ->weight('bold')
                    ->size('lg')
                    ->wrap()
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('traduccions', fn ($q) => $q->where('titol', 'like', "%{$search}%"));
                    }),

                Tables\Columns\TextColumn::make('exposicio.slug')
                    ->label('Exposició')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->grow(false),

                Tables\Columns\TextColumn::make('imatges_count')
                    ->label('Img')
                    ->counts('imatges')
                    ->alignCenter()
                    ->grow(false),

                Tables\Columns\IconColumn::make('te_audio_ad')
                    ->label('AD')
                    ->tooltip('Audiodescripció (cecs)')
                    ->getStateUsing(fn ($record) => $record->traduccions->contains(fn ($t) => !empty($t->audio_descripcio_url)))
                    ->boolean()
                    ->trueIcon('heroicon-o-speaker-wave')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->grow(false),

                Tables\Columns\IconColumn::make('te_signes')
                    ->label('LSC')
                    ->tooltip('Vídeo llengua de signes (Mirada Tàctil)')
                    ->getStateUsing(fn ($record) => $record->materials->contains(fn ($m) => $m->tipus === 'signes'))
                    ->boolean()
                    ->trueIcon('heroicon-o-hand-raised')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('danger')
                    ->falseColor('gray')
                    ->alignCenter()
                    ->grow(false),

                Tables\Columns\IconColumn::make('activa')
                    ->label('Visible')
                    ->boolean()
                    ->alignCenter()
                    ->grow(false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('exposicio_id')
                    ->label('Filtrar per Exposició')
                    ->options(Exposicio::all()->mapWithKeys(fn ($e) => [$e->id => $e->traduccio('ca')?->titol ?? $e->slug]))
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('activa')
                    ->label('Visible'),
            ])
            ->filtersFormColumns(2)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('qr')
                    ->label('QR')
                    ->icon('heroicon-o-qr-code')
                    ->url(fn ($record) => route('filament.admin.resources.pecas.qr', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('ordre')
            ->defaultSort('ordre');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeces::route('/'),
            'create' => Pages\CreatePeca::route('/create'),
            'edit' => Pages\EditPeca::route('/{record}/edit'),
            'qr' => Pages\QrPeca::route('/{record}/qr'),
        ];
    }
}
