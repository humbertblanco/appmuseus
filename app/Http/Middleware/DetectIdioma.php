<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class DetectIdioma
{
    protected array $idiomesDisponibles = ['ca', 'es', 'en', 'fr'];

    public function handle(Request $request, Closure $next): Response
    {
        // Excloure rutes de Livewire i admin
        if ($request->is('livewire/*') || $request->is('admin/*')) {
            return $next($request);
        }

        // Agafar idioma de la cookie o usar catala per defecte
        $idioma = $request->cookie('idioma', 'ca');

        // Validar que sigui un idioma valid
        if (!in_array($idioma, $this->idiomesDisponibles)) {
            $idioma = 'ca';
        }

        // Compartir amb totes les vistes
        view()->share('currentIdioma', $idioma);

        // Generar o llegir visitor_id per identificar visitants
        $visitorId = $request->cookie('visitor_id');
        if (!$visitorId) {
            $visitorId = Str::random(12);
        }
        $request->attributes->set('visitor_id', $visitorId);

        $response = $next($request);

        // Establir cookie visitor_id (1 any)
        if (!$request->cookie('visitor_id')) {
            $response->headers->setCookie(
                cookie('visitor_id', $visitorId, 60 * 24 * 365)
            );
        }

        return $response;
    }
}
