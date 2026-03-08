<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use App\Models\Peca;
use App\Models\PecaMaterial;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PecaController extends Controller
{
    public function show(Request $request, string $idioma, string $exposicio, string $slug)
    {
        // Si ve per QR i té idioma preferit, redirigir al seu idioma
        if ($request->has('qr')) {
            $idiomaPreferit = $request->cookie('idioma');
            if ($idiomaPreferit && $idiomaPreferit !== $idioma && in_array($idiomaPreferit, ['ca', 'es', 'en', 'fr'])) {
                $params = $request->only(['qr', 'ad']);
                return redirect()->route('peca.show', [
                    'idioma' => $idiomaPreferit,
                    'exposicio' => $exposicio,
                    'slug' => $slug,
                ] + $params);
            }
        }

        $peca = Peca::where('slug', $slug)
            ->whereHas('exposicio', fn($q) => $q->where('slug', $exposicio))
            ->activa()
            ->with(['traduccions', 'imatges', 'materials', 'exposicio.traduccions'])
            ->firstOrFail();

        $traduccio = $peca->traduccio($idioma);

        if (!$traduccio) {
            return view('idioma-no-disponible', [
                'idioma' => $idioma,
                'idiomesDisponibles' => $peca->idiomesDisponibles(),
                'tipus' => 'peca',
                'slug' => $slug,
                'exposicioSlug' => $exposicio,
            ]);
        }

        // Registrar estadistica (QR scan, redireccio o visita normal)
        if ($request->has('qr')) {
            Estadistica::registrarQrScan($peca, null, $idioma);
        } elseif ($request->has('redirect')) {
            Estadistica::registrar($peca, null, $idioma, Estadistica::TIPUS_REDIRECCIO);
        } else {
            Estadistica::registrar($peca, null, $idioma);
        }

        $materials = $peca->materialsPerIdioma($idioma)->where('tipus', '!=', 'signes');
        $videoSignes = $peca->materials->where('tipus', 'signes')->first();

        // Mode audiodescripció (pot venir del cookie o del query param ?ad=1)
        $modeAudiodescripcio = $request->has('ad') || $request->cookie('audiodescripcio') == '1';

        // Idiomes amb audiodescripció ÀUDIO disponible per aquesta peça
        $idiomesAmbAudiodescripcio = $peca->traduccions
            ->filter(fn ($t) => $t->teAudioDescripcioAudio())
            ->pluck('idioma')
            ->toArray();

        $response = view('peca', [
            'peca' => $peca,
            'traduccio' => $traduccio,
            'materials' => $materials,
            'videoSignes' => $videoSignes,
            'idioma' => $idioma,
            'modeAudiodescripcio' => $modeAudiodescripcio,
            'idiomesDisponibles' => $peca->idiomesDisponibles(),
            'idiomesAmbAudiodescripcio' => $idiomesAmbAudiodescripcio,
            'slug' => $slug,
            'exposicioSlug' => $exposicio,
        ])->withCookie(cookie('idioma', $idioma, 60 * 24 * 30));

        // Si ve amb ?ad=1, establir també la cookie d'audiodescripció
        if ($request->has('ad')) {
            $response = $response->withCookie(cookie('audiodescripcio', '1', 60 * 24 * 30, '/', null, false, false));
        }

        return $response;
    }

    public function showMaterial(int $id)
    {
        $material = PecaMaterial::with('peca.exposicio')->findOrFail($id);

        return view('material', [
            'material' => $material,
            'idioma' => $material->idioma,
            'peca' => $material->peca,
        ]);
    }

    public function downloadQr(int $id, string $idioma)
    {
        $peca = Peca::with('exposicio')->findOrFail($id);

        // Check if it's an AD QR (idioma ends with -ad)
        $isAD = str_ends_with($idioma, '-ad');
        $realIdioma = $isAD ? str_replace('-ad', '', $idioma) : $idioma;

        $url = route('peca.show', [
            'idioma' => $realIdioma,
            'exposicio' => $peca->exposicio->slug,
            'slug' => $peca->slug,
        ]);

        $url .= '?qr=1';
        if ($isAD) {
            $url .= '&ad=1';
        }

        $svg = QrCode::format('svg')
            ->size(500)
            ->margin(2)
            ->generate($url);

        $filename = $isAD ? 'qr-' . $peca->slug . '-' . $realIdioma . '-ad.svg' : 'qr-' . $peca->slug . '-' . $idioma . '.svg';

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
