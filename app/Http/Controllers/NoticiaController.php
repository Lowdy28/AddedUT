<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\ComentarioNoticia;
use App\Models\LikeNoticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    public function foro()
    {
        $noticias = Noticia::with(['autor', 'likes', 'comentarios'])
            ->where('publicada', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $userId = Auth::id();

        return view('estudiante.noticias.foro', compact('noticias', 'userId'));
    }

    public function show(Noticia $noticia)
    {
        if (!$noticia->publicada) abort(404);

        $noticia->load(['autor', 'likes', 'comentarios.usuario']);
        $userId = Auth::id();

        return view('estudiante.noticias.show', compact('noticia', 'userId'));
    }

    public function toggleLike(Noticia $noticia)
    {
        $userId = Auth::id();

        $like = LikeNoticia::where('id_noticia', $noticia->id_noticia)
                           ->where('id_usuario', $userId)
                           ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            LikeNoticia::create([
                'id_noticia' => $noticia->id_noticia,
                'id_usuario' => $userId,
            ]);
            $liked = true;
        }

        $total = LikeNoticia::where('id_noticia', $noticia->id_noticia)->count();
        return response()->json(['liked' => $liked, 'total' => $total]);
    }

    public function comentar(Request $request, Noticia $noticia)
    {
        $request->validate(['comentario' => 'required|string|max:1000']);

        $comentario = ComentarioNoticia::create([
            'id_noticia' => $noticia->id_noticia,
            'id_usuario' => Auth::id(),
            'comentario' => $request->comentario,
        ]);

        $comentario->load('usuario');

        return response()->json([
            'message' => 'Comentario publicado.',
            'nombre'  => $comentario->usuario->nombre,
            'texto'   => $comentario->comentario,
            'fecha'   => $comentario->created_at->format('d/m/Y H:i'),
            'id'      => $comentario->id_comentario,
        ]);
    }

    public function eliminarComentario(ComentarioNoticia $comentario)
    {
        if ($comentario->id_usuario !== Auth::id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }
        $comentario->delete();
        return response()->json(['message' => 'Comentario eliminado.']);
    }
}
