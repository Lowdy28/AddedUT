<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminNoticiaController extends Controller {
    
    public function index(Request $request) {
        $buscar = $request->input('buscar');
        
        $noticias = Noticia::with('autor')
            ->when($buscar, function ($q) use ($buscar) {
                $q->where('titulo', 'like', "%$buscar%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.noticias.index', compact('noticias'));
    }

    public function store(Request $request) {
        $request->validate([
            'titulo'    => 'required|string|max:200',
            'contenido' => 'required|string',
            'categoria' => 'required',
            'imagen'    => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $path = $request->file('imagen')->store('noticias', 'public');

        Noticia::create([
            'titulo'        => $request->titulo,
            'contenido'     => $request->contenido,
            'categoria'     => $request->categoria,
            'imagen'        => $path,
            'publicado_por' => Auth::id(),
            'publicada'     => true, // Para que aparezca en el foro inmediatamente
        ]);

        return response()->json(['message' => 'Noticia publicada con éxito en el tablón']);
    }

    public function update(Request $request, $id) {
        $noticia = Noticia::findOrFail($id);
        
        $request->validate([
            'titulo'    => 'required|string|max:200',
            'contenido' => 'required|string',
            'categoria' => 'required',
            'imagen'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        $data = [
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
            'categoria' => $request->categoria,
        ];

        if ($request->hasFile('imagen')) {
            if ($noticia->imagen) {
                Storage::disk('public')->delete($noticia->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('noticias', 'public');
        }

        $noticia->update($data);

        return response()->json(['message' => 'Noticia actualizada correctamente']);
    }

    public function destroy($id) {
        $noticia = Noticia::findOrFail($id);
        
        if ($noticia->imagen) {
            Storage::disk('public')->delete($noticia->imagen);
        }
        
        $noticia->delete();

        return response()->json(['message' => 'La noticia ha sido eliminada']);
    }
}
