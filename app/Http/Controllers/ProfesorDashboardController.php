<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Inscripcion;
use App\Models\Noticia;
use Illuminate\Support\Facades\Auth;

class ProfesorDashboardController extends Controller
{
    public function index()
    {
        $profesorId = Auth::id();

       
        $noticias = Noticia::with(['autor', 'likes', 'comentarios'])
            ->where('publicada', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $userId = $profesorId;

        return view('profesor.dashboard', compact('noticias', 'userId'));
    }

    public function miTaller()
    {
        $profesorId = Auth::id();

        $talleres = Evento::where('creado_por', $profesorId)
            ->orderBy('fecha_inicio', 'asc')
            ->get();

        foreach ($talleres as $taller) {
            $taller->inscritos = Inscripcion::where('id_evento', $taller->id_evento)
                ->with('usuario')
                ->get();
        }

        return view('profesor.taller', compact('talleres'));
    }
}