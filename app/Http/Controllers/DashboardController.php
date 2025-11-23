<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Evento;
use App\Models\Inscripcion;

class DashboardController extends Controller
{
    // Dashboard general (estudiantes y profesores)
    public function index()
    {
        return view('dashboard', [
            'usuarios'      => Usuario::count(),
            'eventos'       => Evento::count(),
            'inscripciones' => Inscripcion::count(),
        ]);
    }

    // Dashboard admin
    public function admin()
    {
        return view('dashboard', [
            'usuarios'      => Usuario::count(),
            'eventos'       => Evento::count(),
            'inscripciones' => Inscripcion::count(),
        ]);
    }
}
