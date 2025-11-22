<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    public $timestamps = false;

    protected $fillable = [
        'nombre_evento',
        'descripcion',
        'categoria',
        'fecha_inicio',
        'fecha_fin',
        'cupo_maximo',
        'cupo_disponible',
        'lugar',
        'id_profesor',
        'creado_por',
        'fecha_creacion'
    ];

    public function profesor()
    {
        return $this->belongsTo(Usuario::class, 'id_profesor');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creado_por');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_evento');
    }
}
