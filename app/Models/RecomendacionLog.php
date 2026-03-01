<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecomendacionLog extends Model
{
    protected $table      = 'recomendaciones_log';
    protected $primaryKey = 'id_log';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'id_evento',
        'score',
        'posicion',
        'inscrito',
        'fecha_recomendacion',
    ];

    protected $casts = [
        'inscrito'             => 'boolean',
        'fecha_recomendacion'  => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }
}
