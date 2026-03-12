<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    protected $table      = 'testimonios';
    protected $primaryKey = 'id_testimonio';

    protected $fillable = [
        'id_usuario',
        'estrellas',
        'comentario',
        'aprobado',
    ];

    protected $casts = [
        'aprobado' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
