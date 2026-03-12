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

        $middleware->alias([
            'role'    => \App\Http\Middleware\RoleMiddleware::class,
            'nocache' => \App\Http\Middleware\NoCacheHeaders::class,
            'guest'   => \App\Http\Middleware\RedirectIfAuthenticated::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\NoCacheHeaders::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Cuando el rate limiter bloquea una petición (HTTP 429),
        // en lugar de mostrar la página de error genérica de Laravel,
        // redirigimos de vuelta al formulario con un mensaje claro.
        $exceptions->render(function (
            \Illuminate\Http\Exceptions\ThrottleRequestsException $e,
            \Illuminate\Http\Request $request
        ) {
            $segundos = (int) $e->getHeaders()['Retry-After'] ?? 120;

            // Si venía del paso de verificación o de guardar contraseña
            if ($request->is('recuperar/*') || $request->is('recuperar')) {
                return redirect()->route('recuperar')
                    ->withErrors([
                        'matricula' => "Demasiados intentos. Espera {$segundos} segundos antes de intentar de nuevo.",
                    ]);
            }

            // Para cualquier otra ruta, respuesta JSON o redirección al login
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Demasiadas solicitudes. Intenta más tarde.'], 429);
            }

            return redirect()->back()
                ->withErrors(['error' => "Demasiadas solicitudes. Espera {$segundos} segundos."]);
        });

    })->create();
    