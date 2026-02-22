<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComentarioNoticia extends Model
{
    protected $table = 'comentarios_noticias';
    protected $primaryKey = 'id_comentario';

    protected $fillable = [
        'id_noticia',
        'id_usuario',
        'comentario',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function noticia()
    {
        return $this->belongsTo(Noticia::class, 'id_noticia', 'id_noticia');
    }
}
