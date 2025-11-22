<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Evento;
use App\Models\Inscripcion;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'usuarios'      => User::count(),
            'eventos'       => Evento::count(),
            'inscripciones' => Inscripcion::count(),
        ]);
    }
}
