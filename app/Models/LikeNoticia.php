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
}
