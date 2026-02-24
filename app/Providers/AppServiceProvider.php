<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Evento; // Importamos el modelo correcto
use App\Observers\ActividadObserver; 

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Ahora sí, vinculamos el modelo que usa tu controlador
        Evento::observe(ActividadObserver::class);
    }
}