<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Auth;

class EstudianteEventoController extends Controller
{
    /**
     * Muestra el listado de eventos para el estudiante.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        
        $eventos = Evento::when($buscar, fn($q) => $q->where('nombre','like',"%{$buscar}%"))
                              ->orderBy('fecha_inicio','asc')
                              ->paginate(12);

        $userId = Auth::id();
        $inscritoEventIds = Inscripcion::where('id_usuario', $userId)
                                         ->pluck('id_evento')
                                         ->toArray();

        return view('estudiante.eventos.index', compact('eventos', 'inscritoEventIds'));
    }

    /**
     * Muestra los detalles de un evento específico para el estudiante.
     *
     * @param  \App\Models\Evento  $evento
     * @return \Illuminate\Http\Response
     */
    public function show(Evento $evento)
    {
        // ✅ CORRECCIÓN: Inicializar la variable por defecto
        $estaInscrito = false; 
        
        $userId = Auth::id(); // Tomamos el ID del usuario logeado
        
        if ($userId) { // Usamos el ID para verificar si hay un usuario logeado
            $estaInscrito = Inscripcion::where('id_usuario', $userId)
                                        ->where('id_evento', $evento->id_evento)
                                        ->exists();
        }

        $evento->load('creador'); 

        return view('estudiante.eventos.showEstudiante', compact('evento', 'estaInscrito'));
    }
}