<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CambioHorarioNotification extends Notification
{
    use Queueable;

    protected $detalles;

    public function __construct($detalles)
    {
        $this->detalles = $detalles;
    }

    public function via($notifiable)
    {
        // Guardamos en la base de datos para que aparezca en la campana
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => $this->detalles['titulo'],
            'mensaje' => $this->detalles['mensaje'],
            'tipo' => $this->detalles['tipo'], // 'cambio' o 'cancelada'
        ];
    }
}