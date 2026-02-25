<?php

namespace App\Observers;

use App\Models\Evento;
use App\Models\User;
use App\Notifications\CambioHorarioNotification;

class ActividadObserver
{
    public function updated(Evento $evento)
    {
        $estudiantes = User::where('rol', 'estudiante')->get();
        $url = route('estudiante.eventos.show', $evento->id_evento);

        if ($evento->wasChanged('fecha_inicio')) {
            $this->notificar($estudiantes, [
                'titulo' => 'Cambio de horario: ' . $evento->nombre,
                'mensaje' => 'Se ha modificado el horario del evento. Revisa los nuevos detalles.',
                'tipo' => 'cambio',
                'url' => $url,
            ]);
        }

        if ($evento->wasChanged('cupos')) {
            $cuposNuevos = $evento->cupos;
            $cuposAnteriores = $evento->getOriginal('cupos');

            if ($cuposNuevos > $cuposAnteriores) {
                $this->notificar($estudiantes, [
                    'titulo' => '¡Nuevos cupos disponibles: ' . $evento->nombre . '!',
                    'mensaje' => 'Se han abierto más cupos para este evento. ¡Date prisa!',
                    'tipo' => 'cupos_disponibles',
                    'url' => $url,
                ]);
            }

            if ($cuposNuevos <= 0) {
                $this->notificar($estudiantes, [
                    'titulo' => 'Sin cupos: ' . $evento->nombre,
                    'mensaje' => 'Este evento ya no tiene cupos disponibles.',
                    'tipo' => 'sin_cupos',
                    'url' => $url,
                ]);
            }
        }

        if ($evento->wasChanged(['nombre', 'descripcion', 'lugar'])) {
            $this->notificar($estudiantes, [
                'titulo' => 'Información actualizada: ' . $evento->nombre,
                'mensaje' => 'Se ha actualizado información importante de este evento.',
                'tipo' => 'info',
                'url' => $url,
            ]);
        }
    }

    private function notificar($estudiantes, $detalles)
    {
        foreach ($estudiantes as $estudiante) {
            $estudiante->notify(new CambioHorarioNotification($detalles));
        }
    }
}