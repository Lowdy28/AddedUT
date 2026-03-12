<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable implements CanResetPasswordContract
{
    use HasFactory, Notifiable, CanResetPassword;

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
