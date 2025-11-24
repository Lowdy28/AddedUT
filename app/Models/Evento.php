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
        'nombre',           // ← Esta columna
        'descripcion',
        'categoria',
        'fecha_inicio',
        'fecha_fin',
        'cupos',           // ← Esta columna
        'lugar',
        'creado_por',
        'fecha_creacion'
    ];

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creado_por', 'id_usuario');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_evento');
    }
}