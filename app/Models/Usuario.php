<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table      = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public    $incrementing = true;
    protected $keyType      = 'int';
    public    $timestamps   = false;

    protected $fillable = [
        'nombre',
        'matricula',
        'email',
        'password',
        'foto',
        'rol',
        'activo',
        'fecha_registro',
    ];

    protected $hidden = [
        'password',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Detecta el rol a partir de la matricula institucional UTTEC.
     *
     * Reglas:
     *   - Estudiante: exactamente 10 digitos numericos (ej. 2523260044)
     *   - Profesor:   empieza con una o mas letras seguidas de digitos (ej. P2301, D240015)
     *
     * @param  string $matricula  Parte antes del @ del correo institucional
     * @return string|null        'estudiante' | 'profesor' | null si no reconoce
     */
    public static function detectarRolPorMatricula(string $matricula): ?string
    {
        $matricula = trim($matricula);


        if (preg_match('/^\d{10}$/', $matricula)) {
            return 'estudiante';
        }

        if (preg_match('/^[A-Za-z]+\d{2,}$/i', $matricula)) {
            return 'profesor';
        }

        return null;
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_usuario', 'id_usuario');
    }
}
