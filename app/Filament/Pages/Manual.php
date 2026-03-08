<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Manual extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Manual';
    protected static ?string $title = 'Manual d\'administracio';
    protected static ?int $navigationSort = 99;
    protected static ?string $navigationGroup = 'Configuracio';

    protected static string $view = 'filament.pages.manual';
}
