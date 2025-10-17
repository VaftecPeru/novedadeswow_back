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
    ->withMiddleware(function (Middleware $middleware) {
        // Registrar el middleware personalizado
        $middleware->alias([
            'auth.token' => \App\Http\Middleware\AuthTokenMiddleware::class,
        ]);

        // Configurar middlewares para el grupo 'api'
        $middleware->api([
            'throttle:60,1', // 60 solicitudes por minuto
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Http\Middleware\HandleCors::class, // CORS
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();