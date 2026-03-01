<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInteres extends Model
{
    protected $table      = 'user_intereses';
    protected $primaryKey = 'id_interes';

    protected $fillable = [
        'id_usuario',
        'tipo_actividad',
        'modalidad',
        'experiencia',
        'horario_preferido',
        'objetivo',
        'cuestionario_completado',
    ];

    protected $casts = [
        'cuestionario_completado' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }
}
