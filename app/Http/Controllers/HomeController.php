<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use App\Models\Exposicio;
use App\Models\Peca;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request, ?string $idioma = null)
    {
        $idioma = $idioma ?? $request->cookie('idioma', 'ca');

        $totesExposicions = Exposicio::activa()
            ->ordenada()
            ->with(['traduccions', 'peces.traduccions'])
            ->get();

        // Registrar visita a la home
        Estadistica::registrar(null, null, $idioma);

        $exposicions = $totesExposicions->filter(fn ($e) => $e->traduccio($idioma) !== null);

        if ($exposicions->isEmpty() && $idioma !== 'ca') {
            return redirect()->route('home', ['idioma' => 'ca']);
        }

        // Calcular idiomes disponibles basant-se en les exposicions que tenen traduccions
        $idiomesDisponibles = $totesExposicions
            ->flatMap(fn ($e) => $e->idiomesDisponibles())
            ->unique()
            ->values()
            ->toArray();

        // Idiomes amb audiodescripció ÀUDIO disponible (de qualsevol peça)
        $idiomesAmbAudiodescripcio = $totesExposicions
            ->flatMap(fn ($e) => $e->peces)
            ->flatMap(fn ($p) => $p->traduccions->filter(fn ($t) => $t->teAudioDescripcioAudio())->pluck('idioma'))
            ->unique()
            ->values()
            ->toArray();

        $totalPeces = $totesExposicions->flatMap(fn ($e) => $e->peces)->filter(fn ($p) => $p->activa)->count();

        return view('home', [
            'exposicions' => $exposicions,
            'totalPeces' => $totalPeces,
            'idioma' => $idioma,
            'idiomesDisponibles' => $idiomesDisponibles,
            'idiomesAmbAudiodescripcio' => $idiomesAmbAudiodescripcio,
        ])->withCookie(cookie('idioma', $idioma, 60 * 24 * 30));
    }
}
