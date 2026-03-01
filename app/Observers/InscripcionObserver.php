<?php

namespace App\Observers;

use App\Models\Inscripcion;
use App\Models\User;
use App\Notifications\CambioHorarioNotification;

class InscripcionObserver
{
    public function created(Inscripcion $inscripcion)
    {
        $evento     = $inscripcion->evento;
        $estudiante = User::find($inscripcion->id_usuario);

        if (!$evento || !$estudiante) return;

        $admins     = User::where('rol', 'admin')->get();
        $profesores = User::where('rol', 'profesor')->get();

        foreach ($admins as $admin) {
            $admin->notify(new CambioHorarioNotification([
                'titulo'  => 'Nueva inscripción: ' . $evento->nombre,
                'mensaje' => $estudiante->nombre . ' se ha inscrito al taller.',
                'tipo'    => 'inscripcion',
                'url'     => route('eventos.show', $evento->id_evento),
            ]));
        }

        foreach ($profesores as $profesor) {
            $profesor->notify(new CambioHorarioNotification([
                'titulo'  => 'Nuevo alumno en tu taller: ' . $evento->nombre,
                'mensaje' => $estudiante->nombre . ' se ha inscrito a tu taller.',
                'tipo'    => 'inscripcion',
                'url'     => route('profesor.taller'),
            ]));
        }
    }

    public function deleted(Inscripcion $inscripcion)
    {
        $evento     = $inscripcion->evento;
        $estudiante = User::find($inscripcion->id_usuario);

        if (!$evento || !$estudiante) return;

        $admins     = User::where('rol', 'admin')->get();
        $profesores = User::where('rol', 'profesor')->get();

        foreach ($admins as $admin) {
            $admin->notify(new CambioHorarioNotification([
                'titulo'  => 'Baja en taller: ' . $evento->nombre,
                'mensaje' => $estudiante->nombre . ' se ha dado de baja del taller.',
                'tipo'    => 'baja',
                'url'     => route('eventos.show', $evento->id_evento),
            ]));
        }

        foreach ($profesores as $profesor) {
            $profesor->notify(new CambioHorarioNotification([
                'titulo'  => 'Baja en tu taller: ' . $evento->nombre,
                'mensaje' => $estudiante->nombre . ' se ha dado de baja de tu taller.',
                'tipo'    => 'baja',
                'url'     => route('profesor.taller'),
            ]));
        }
    }
}