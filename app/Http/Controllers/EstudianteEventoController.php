<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EstudianteEventoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $eventos = Evento::when($buscar, fn($q) => $q->where('nombre','like',"%{$buscar}%"))
                         ->orderBy('fecha_inicio','asc')
                         ->paginate(12);

        return view('estudiante.eventos.index', compact('eventos'));
    }
}
