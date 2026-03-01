<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Inscripcion;
use App\Models\UserInteres;
use Illuminate\Support\Facades\Auth;

class EstudianteDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $eventos = Evento::orderBy('fecha_inicio', 'asc')->paginate(12);

        $misInscripciones = Inscripcion::where('id_usuario', $user->id_usuario)
                                       ->with('evento')
                                       ->orderBy('fecha_inscripcion', 'desc')
                                       ->get();

        $inscritoEventIds = $misInscripciones->pluck('id_evento')->toArray();

        $interes = UserInteres::where('id_usuario', $user->id_usuario)->first();

        $mostrarCuestionario = !$interes || !$interes->cuestionario_completado;

        return view('estudiante.dashboard', compact(
            'eventos',
            'misInscripciones',
            'inscritoEventIds',
            'mostrarCuestionario'
        ));
    }
}
