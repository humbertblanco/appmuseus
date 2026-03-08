<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend([
            \App\Http\Middleware\HandleRedireccions::class,
        ]);

        $middleware->web(prepend: [
            \App\Http\Middleware\DetectIdioma::class,
        ]);

        // Cookies que no s'encripten (per poder-les llegir des de JavaScript)
        $middleware->encryptCookies(except: ['audiodescripcio', 'visitor_id', 'idioma']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
