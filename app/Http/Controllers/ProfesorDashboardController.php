<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\Auth;

class ProfesorDashboardController extends Controller
{
    public function index()
    {
        $profesorId = Auth::id();

        // 🔥 Obtener solo los talleres creados por este profesor
        $talleres = Evento::where('creado_por', $profesorId)
                          ->orderBy('fecha_inicio', 'asc')
                          ->get();

        // 🔥 Para cada taller, obtener sus inscripciones (alumnos)
        foreach ($talleres as $taller) {
            $taller->inscritos = Inscripcion::where('id_evento', $taller->id_evento)
                                            ->with('usuario') // Para acceder al nombre del alumno
                                            ->get();
        }

        return view('profesor.dashboard', compact('talleres'));
    }
}
