<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::with('usuario')->orderBy('fecha_envio','desc')->paginate(25);
        return view('notificaciones.index', compact('notificaciones'));
    }

    public function create()
    {
        $usuarios = Usuario::all();
        return view('notificaciones.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'mensaje' => 'required|string',
            'tipo' => 'required|in:correo,alerta_web,sistema',
        ]);

        Notificacion::create($data);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación creada.');
    }

    public function show(Notificacion $notificacion)
    {
        return view('notificaciones.show', compact('notificacion'));
    }

    public function edit(Notificacion $notificacion)
    {
        $usuarios = Usuario::all();
        return view('notificaciones.edit', compact('notificacion','usuarios'));
    }

    public function update(Request $request, Notificacion $notificacion)
    {
        $data = $request->validate([
            'mensaje' => 'required|string',
            'tipo' => 'required|in:correo,alerta_web,sistema',
            'leida' => 'nullable|boolean',
        ]);

        $notificacion->update($data);

        return redirect()->route('notificaciones.index')->with('success', 'Notificación actualizada.');
    }

    public function destroy(Notificacion $notificacion)
    {
        $notificacion->delete();
        return redirect()->route('notificaciones.index')->with('success', 'Notificación eliminada.');
    }

    public function marcarLeida(Notificacion $notificacion)
    {
        $notificacion->update(['leida' => true]);
        return redirect()->back()->with('success', 'Notificación marcada como leída.');
    }
}
