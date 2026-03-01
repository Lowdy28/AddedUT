<?php

namespace App\Observers;

use App\Models\Noticia;
use App\Models\LikeNoticia;
use App\Models\User;
use App\Notifications\CambioHorarioNotification;

class NoticiaObserver
{
    public function created(Noticia $noticia)
    {
        $estudiantes = User::where('rol', 'estudiante')->get();
        $url = route('estudiante.noticias.foro');

        foreach ($estudiantes as $estudiante) {
            $estudiante->notify(new CambioHorarioNotification([
                'titulo'  => '¡' . $noticia->titulo . '!',
                'mensaje' => 'Hay una nueva noticia en la universidad. ¡Échale un vistazo!',
                'tipo'    => 'noticia',
                'url'     => $url,
            ]));
        }
    }
}