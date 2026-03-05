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

    // Se incluye en la serialización JSON para que Alpine/Blade lo reciban
    protected $appends = ['imagen_url'];

    /**
     * Mapa de imágenes estáticas (fallback cuando no hay imagen subida).
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
     * URL de imagen siempre válida:
     *   1. Imagen subida en storage  → asset('storage/...')   ← usa asset() no Storage::url()
     *   2. Nombre en el mapa estático → asset('imagenes/...')
     *   3. Fallback                   → asset('imagenes/uttec.jpeg')
     *
     * Usamos asset('storage/' . $this->imagen) en lugar de Storage::disk('public')->url()
     * para que la URL siempre use la URL base del servidor actual sin depender de APP_URL.
     */
    public function getImagenUrlAttribute(): string
    {
        if (!empty($this->imagen)) {
            // Verificar que el archivo realmente existe antes de devolverlo
            if (Storage::disk('public')->exists($this->imagen)) {
                return asset('storage/' . $this->imagen);
            }
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
