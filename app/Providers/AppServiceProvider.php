<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Evento;
use App\Models\Noticia;
use App\Observers\ActividadObserver;
use App\Observers\NoticiaObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Evento::observe(ActividadObserver::class);
        Noticia::observe(NoticiaObserver::class);
    }
}