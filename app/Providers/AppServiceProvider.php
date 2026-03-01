<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Evento;
use App\Models\Noticia;
use App\Models\Inscripcion;
use App\Models\LikeNoticia;
use App\Observers\ActividadObserver;
use App\Observers\NoticiaObserver;
use App\Observers\InscripcionObserver;
use App\Observers\LikeNoticiaObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Evento::observe(ActividadObserver::class);
        Noticia::observe(NoticiaObserver::class);
        Inscripcion::observe(InscripcionObserver::class);
        LikeNoticia::observe(LikeNoticiaObserver::class);
    }
}