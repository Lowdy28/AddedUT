<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'mensaje',
        'tipo',
        'leida',
        'fecha_envio'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
