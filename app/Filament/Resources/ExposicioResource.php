<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExposicioResource\Pages;
use App\Filament\Resources\ExposicioResource\RelationManagers;
use App\Models\Exposicio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ExposicioResource extends Resource
{
    protected static ?string $model = Exposicio::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Exposicions';
    protected static ?string $modelLabel = 'Exposició';
    protected static ?string $pluralModelLabel = 'Exposicions';
    protected static ?string $navigationGroup = 'Contingut';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informació bàsica')
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\FileUpload::make('imatge_portada')
                                ->image()
                                ->disk('public')
                                ->directory('exposicions')
                                ->visibility('public')
                                ->imagePreviewHeight('200')
                                ->maxSize(5120)
                                ->columnSpan(2),

                            Forms\Components\Grid::make(1)->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->label('URL')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->helperText('Identificador únic per a la URL'),

                                Forms\Components\TextInput::make('ordre')
                                    ->numeric()
                                    ->default(fn () => (Exposicio::max('ordre') ?? 0) + 1)
                                    ->unique(ignoreRecord: true)
                                    ->validationMessages(['unique' => 'Aquest número d\'ordre ja existeix.'])
                                    ->helperText('Número únic, auto-assignat'),

                                Forms\Components\Toggle::make('activa')
                                    ->label('Visible')
                                    ->default(true),
                            ]),
                        ]),
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

                Forms\Components\Section::make('Documents / Fulls de sala')
                    ->description('PDFs que es visualitzaran a la pàgina de l\'exposició')
                    ->collapsed()
                    ->collapsible()
                    ->schema([
                        Forms\Components\Repeater::make('documents_data')
                            ->label('Documents')
                            ->defaultItems(0)
                            ->schema([
                                Forms\Components\Grid::make(3)->schema([
                                    Forms\Components\Select::make('idioma')
                                        ->label('Idioma')
                                        ->options([
                                            'ca' => 'Català',
                                            'es' => 'Castellà',
                                            'en' => 'Anglès',
                                            'fr' => 'Francès',
                                        ])
                                        ->required(),

                                    Forms\Components\TextInput::make('titol')
                                        ->label('Títol')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('ordre')
                                        ->label('Ordre')
                                        ->numeric()
                                        ->default(0),
                                ]),

                                Forms\Components\TextInput::make('descripcio')
                                    ->label('Descripció curta')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('fitxer')
                                    ->label('Fitxer PDF')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->disk('public')
                                    ->directory('documents')
                                    ->visibility('public')
                                    ->openable()
                                    ->required()
                                    ->maxSize(20480)
                                    ->columnSpanFull(),

                                Forms\Components\Toggle::make('actiu')
                                    ->label('Actiu')
                                    ->default(true),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => ($state['titol'] ?? '') . ' (' . ($state['idioma'] ?? '') . ')'),
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

            Forms\Components\Textarea::make("traduccions.{$idioma}.descripcio")
                ->label('Descripció')
                ->rows(4),

            Forms\Components\TextInput::make("traduccions.{$idioma}.adreca")
                ->label('Adreça')
                ->maxLength(255),

            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make("traduccions.{$idioma}.telefon")
                    ->label('Telèfon')
                    ->tel()
                    ->maxLength(50),

                Forms\Components\TextInput::make("traduccions.{$idioma}.email")
                    ->label('Email')
                    ->email()
                    ->maxLength(255),
            ]),

            Forms\Components\Grid::make(3)->schema([
                Forms\Components\TextInput::make("traduccions.{$idioma}.web_url")
                    ->label('Web')
                    ->url()
                    ->maxLength(255),

                Forms\Components\TextInput::make("traduccions.{$idioma}.facebook_url")
                    ->label('Facebook')
                    ->url()
                    ->maxLength(255),

                Forms\Components\TextInput::make("traduccions.{$idioma}.instagram_url")
                    ->label('Instagram')
                    ->url()
                    ->maxLength(255),
            ]),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('imatge_portada')
                    ->label('')
                    ->disk('public')
                    ->size(60)
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
                    })
                    ->sortable(query: function ($query, string $direction) {
                        return $query->orderBy(
                            \App\Models\ExposicioTraduccio::select('titol')
                                ->whereColumn('exposicio_id', 'exposicions.id')
                                ->where('idioma', 'ca')
                                ->limit(1),
                            $direction
                        );
                    }),

                Tables\Columns\TextColumn::make('slug')
                    ->label('URL')
                    ->color('gray')
                    ->size('sm')
                    ->grow(false)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('peces_count')
                    ->label('Peces')
                    ->counts('peces')
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->grow(false),

                Tables\Columns\IconColumn::make('activa')
                    ->label('Visible')
                    ->boolean()
                    ->alignCenter()
                    ->grow(false),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activa')
                    ->label('Visible'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('qr')
                    ->label('QR')
                    ->icon('heroicon-o-qr-code')
                    ->url(fn ($record) => route('filament.admin.resources.exposicios.qr', $record))
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
        return [
            RelationManagers\PecesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExposicions::route('/'),
            'create' => Pages\CreateExposicio::route('/create'),
            'edit' => Pages\EditExposicio::route('/{record}/edit'),
            'qr' => Pages\QrExposicio::route('/{record}/qr'),
        ];
    }
}
