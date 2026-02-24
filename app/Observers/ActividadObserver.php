<?php

namespace App\Observers;

use App\Models\Evento;
use App\Models\User;
use App\Notifications\CambioHorarioNotification;
use Illuminate\Support\Facades\Log;

class ActividadObserver
{
    public function updated(Evento $evento)
    {
        Log::info('¡El Observer de Eventos se ha activado!');

        if ($evento->wasChanged(['nombre', 'fecha_inicio'])) {

            $detalles = [
                'titulo' => 'Evento Actualizado: ' . $evento->nombre,
                'mensaje' => 'Se ha modificado la fecha o el nombre del evento.',
                'tipo' => 'cambio'
            ];

            $estudiantes = User::where('rol', 'estudiante')->get();

            foreach ($estudiantes as $estudiante) {
                $estudiante->notify(new CambioHorarioNotification($detalles));
            }

            Log::info('Notificaciones enviadas a ' . $estudiantes->count() . ' estudiantes.');
        }
    }
}