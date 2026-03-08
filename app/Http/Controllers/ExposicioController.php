<?php

namespace App\Http\Controllers;

use App\Models\Estadistica;
use App\Models\Exposicio;
use App\Models\ExposicioDocument;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ExposicioController extends Controller
{
    public function show(Request $request, string $idioma, string $slug)
    {
        // Si ve per QR i té idioma preferit, redirigir al seu idioma
        if ($request->has('qr')) {
            $idiomaPreferit = $request->cookie('idioma');
            if ($idiomaPreferit && $idiomaPreferit !== $idioma && in_array($idiomaPreferit, ['ca', 'es', 'en', 'fr'])) {
                return redirect()->route('exposicio.show', [
                    'idioma' => $idiomaPreferit,
                    'slug' => $slug,
                ] + $request->only(['qr']));
            }
        }

        $exposicio = Exposicio::where('slug', $slug)
            ->activa()
            ->with(['traduccions', 'peces.traduccions', 'peces.imatges', 'documents'])
            ->firstOrFail();

        $traduccio = $exposicio->traduccio($idioma);

        if (!$traduccio) {
            return view('idioma-no-disponible', [
                'idioma' => $idioma,
                'idiomesDisponibles' => $exposicio->idiomesDisponibles(),
                'tipus' => 'exposicio',
                'slug' => $slug,
            ]);
        }

        // Registrar estadistica (QR scan, redireccio o visita normal)
        if ($request->has('qr')) {
            Estadistica::registrarQrScan(null, $exposicio, $idioma);
        } elseif ($request->has('redirect')) {
            Estadistica::registrar(null, $exposicio, $idioma, Estadistica::TIPUS_REDIRECCIO);
        } else {
            Estadistica::registrar(null, $exposicio, $idioma);
        }

        $peces = $exposicio->peces()
            ->activa()
            ->ordenada()
            ->get()
            ->filter(fn ($p) => $p->traduccio($idioma) !== null);

        // Documents per l'idioma actual
        $documents = $exposicio->documentsPerIdioma($idioma);

        // Idiomes amb audiodescripció ÀUDIO disponible (de qualsevol peça de l'exposició)
        $idiomesAmbAudiodescripcio = $exposicio->peces
            ->flatMap(fn ($p) => $p->traduccions->filter(fn ($t) => $t->teAudioDescripcioAudio())->pluck('idioma'))
            ->unique()
            ->values()
            ->toArray();

        return view('exposicio', [
            'exposicio' => $exposicio,
            'traduccio' => $traduccio,
            'peces' => $peces,
            'documents' => $documents,
            'idioma' => $idioma,
            'idiomesDisponibles' => $exposicio->idiomesDisponibles(),
            'idiomesAmbAudiodescripcio' => $idiomesAmbAudiodescripcio,
            'slug' => $slug,
        ])->withCookie(cookie('idioma', $idioma, 60 * 24 * 30));
    }

    public function showDocument(int $id)
    {
        $document = ExposicioDocument::findOrFail($id);

        if (!$document->actiu) {
            abort(404);
        }

        return view('document', [
            'document' => $document,
            'idioma' => $document->idioma,
        ]);
    }

    public function downloadQr(int $id, string $idioma)
    {
        $exposicio = Exposicio::findOrFail($id);
        $url = route('exposicio.show', ['idioma' => $idioma, 'slug' => $exposicio->slug]) . '?qr=1';

        $svg = QrCode::format('svg')
            ->size(500)
            ->margin(2)
            ->generate($url);

        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="qr-' . $exposicio->slug . '-' . $idioma . '.svg"');
    }
}
