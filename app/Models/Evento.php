<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Evento extends Model
{
    use HasFactory;

    protected $table      = 'eventos';
    protected $primaryKey = 'id_evento';
    public    $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria',
        'imagen',
        'fecha_inicio',
        'fecha_fin',
        'cupos',
        'cupo_disponible',
        'lugar',
        'horario',
        'dias',
        'creado_por',
        'fecha_creacion',
    ];

    // Se incluye en la serialización JSON para que Alpine lo reciba en openEdit
    protected $appends = ['imagen_url'];

    /**
     * Mapa de imágenes estáticas para los talleres del seeder.
     * Se usa como fallback cuando el taller no tiene imagen subida.
     */
    private static array $mapaImagenes = [
        'Bailes de Salón'   => 'imagenes/baile.jpg',
        'Baile'             => 'imagenes/baile.jpg',
        'Música'            => 'imagenes/musica.jpg',
        'Musica'            => 'imagenes/musica.jpg',
        'Oratoria y Dibujo' => 'imagenes/dibujo.jpg',
        'Dibujo'            => 'imagenes/dibujo.jpg',
        'Teatro'            => 'imagenes/teatro.jpg',
        'Ajedrez'           => 'imagenes/ajedrez.jpg',
        'Basquetbol'        => 'imagenes/basquet.jpg',
        'Básquetbol'        => 'imagenes/basquet.jpg',
        'Fútbol americano'  => 'imagenes/americano.jpg',
        'Fútbol Americano'  => 'imagenes/americano.jpg',
        'Fútbol rápido y 7' => 'imagenes/frapido.jpg',
        'Fútbol Rápido'     => 'imagenes/frapido.jpg',
        'Fútbol soccer'     => 'imagenes/soccer.jpg',
        'Fútbol Soccer'     => 'imagenes/soccer.jpg',
        'Taekwondo'         => 'imagenes/taekwdo.jpg',
        'Voleibol'          => 'imagenes/volei.jpg',
    ];

    /**
     * Devuelve siempre una URL de imagen válida:
     *   1. Si el taller tiene imagen subida en storage → URL de storage
     *   2. Si el nombre coincide con el mapa de imágenes estáticas → asset()
     *   3. Fallback → imagen genérica UTTEC
     */
    public function getImagenUrlAttribute(): string
    {
        if (!empty($this->imagen)) {
            return Storage::disk('public')->url($this->imagen);
        }

        if (isset(self::$mapaImagenes[$this->nombre])) {
            return asset(self::$mapaImagenes[$this->nombre]);
        }

        return asset('imagenes/uttec.jpeg');
    }

    public function creador()
    {
        return $this->belongsTo(Usuario::class, 'creado_por', 'id_usuario');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'id_evento');
    }

    public function profesor()
    {
        return $this->belongsTo(Usuario::class, 'creado_por', 'id_usuario');
    }
}
