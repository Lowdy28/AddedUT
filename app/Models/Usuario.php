<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'rol',
        'fecha_registro',
        'activo'
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthIdentifierName()
    {
        return 'correo';
    }

    public function eventosImpartidos()
    {
        return $this->hasMany(Evento::class, 'id_profesor');
    }

    public function eventosCreados()
    {
        return $this->hasMany(Evento::class, 'creado_por');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_usuario');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_usuario');
    }
}
