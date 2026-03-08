<?php

use App\Http\Controllers\ExposicioController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PecaController;
use Illuminate\Support\Facades\Route;

// Home - llistat d'exposicions
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/{idioma}', [HomeController::class, 'index'])
    ->where('idioma', 'ca|es|en|fr')
    ->name('home.idioma');

// Exposició
Route::get('/{idioma}/exposicio/{slug}', [ExposicioController::class, 'show'])
    ->where('idioma', 'ca|es|en|fr')
    ->name('exposicio.show');

// Peça (sala) - dins de l'exposició
Route::get('/{idioma}/{exposicio}/{slug}', [PecaController::class, 'show'])
    ->where('idioma', 'ca|es|en|fr')
    ->name('peca.show');

// Toggle audiodescripció
Route::post('/toggle-audiodescripcio', function () {
    $actual = request()->cookie('audiodescripcio', false);
    $nou = !$actual;

    return back()->withCookie(cookie('audiodescripcio', $nou, 60 * 24 * 30));
})->name('toggle.audiodescripcio');

// Visualitzador de documents PDF (exposicions)
Route::get('/document/{id}', [ExposicioController::class, 'showDocument'])
    ->name('document.show');

// Visualitzador de materials PDF (peces)
Route::get('/material/{id}', [PecaController::class, 'showMaterial'])
    ->name('material.show');

// QR Downloads
Route::get('/qr/exposicio/{id}/{idioma}', [ExposicioController::class, 'downloadQr'])
    ->name('exposicio.qr.download');
Route::get('/qr/peca/{id}/{idioma}', [PecaController::class, 'downloadQr'])
    ->name('peca.qr.download');
