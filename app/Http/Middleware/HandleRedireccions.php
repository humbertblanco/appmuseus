<?php

namespace App\Http\Middleware;

use App\Models\Redireccio;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleRedireccions
{
    public function handle(Request $request, Closure $next): Response
    {
        // Excloure rutes que no poden ser redireccions
        if ($request->is('livewire/*') || $request->is('admin/*') || $request->is('storage/*') || $request->is('css/*') || $request->is('js/*') || $request->is('vendor/*')) {
            return $next($request);
        }

        $path = '/' . ltrim($request->path(), '/');
        $pathAmbBarra = rtrim($path, '/') . '/';

        // Cache de redireccions per evitar queries a cada petició
        $redireccions = cache()->remember('redireccions_actives', 300, function () {
            return Redireccio::activa()->get(['origen', 'desti', 'tipus'])->keyBy('origen');
        });

        $redireccio = $redireccions->get($path) ?? $redireccions->get($pathAmbBarra);

        if ($redireccio) {
            $desti = $redireccio->desti;

            // Marcar com a redireccio (no QR real) per separar-ho a estadistiques
            if ($desti !== '/') {
                $separator = str_contains($desti, '?') ? '&' : '?';
                $desti = $desti . $separator . 'redirect=1';
            }

            return redirect($desti, $redireccio->tipus);
        }

        return $next($request);
    }
}
