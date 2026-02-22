<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Noticia extends Model
{
    use HasFactory;

    protected $table = 'noticias';
    protected $primaryKey = 'id_noticia';

    protected $fillable = [
        'titulo',
        'contenido',
        'imagen',
        'categoria',
        'publicada',
        'publicado_por',
    ];

    public function autor()
    {
        return $this->belongsTo(Usuario::class, 'publicado_por', 'id_usuario');
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioNoticia::class, 'id_noticia', 'id_noticia')
                    ->with('usuario')
                    ->orderBy('created_at', 'asc');
    }

    public function likes()
    {
        return $this->hasMany(LikeNoticia::class, 'id_noticia', 'id_noticia');
    }

    public function likeDelUsuario($userId)
    {
        return $this->likes()->where('id_usuario', $userId)->exists();
    }

    public function totalLikes()
    {
        return $this->likes()->count();
    }
}
