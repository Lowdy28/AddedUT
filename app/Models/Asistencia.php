<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table      = 'asistencias';
    protected $primaryKey = 'id_asistencia';

    protected $fillable = [
        'id_evento',
        'id_usuario',
        'fecha',
        'estado',
        'nota',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
