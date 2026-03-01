<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeNoticia extends Model
{
    protected $table = 'likes_noticias';

    protected $fillable = [
        'id_noticia',
        'id_usuario',
    ];

    public function noticia()
    {
        return $this->belongsTo(Noticia::class, 'id_noticia', 'id_noticia');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\Usuario::class, 'id_usuario', 'id_usuario');
    }
}