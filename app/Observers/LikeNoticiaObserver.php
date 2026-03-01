<?php

namespace App\Observers;

use App\Models\LikeNoticia;
use App\Models\User;
use App\Notifications\CambioHorarioNotification;

class LikeNoticiaObserver
{
    public function created(LikeNoticia $like)
    {
        $noticia   = $like->noticia;
        $estudiante = User::find($like->id_usuario);

        if (!$noticia || !$estudiante) return;

        $admins    = User::where('rol', 'admin')->get();
        $profesores = User::where('rol', 'profesor')->get();
        $receptores = $admins->merge($profesores);

        foreach ($receptores as $receptor) {
            $receptor->notify(new CambioHorarioNotification([
                'titulo'  => '❤️ Reacción en: ' . $noticia->titulo,
                'mensaje' => $estudiante->nombre . ' reaccionó a una noticia.',
                'tipo'    => 'like',
                'url'     => '#',
            ]));
        }
    }
}