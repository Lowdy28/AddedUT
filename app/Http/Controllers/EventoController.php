<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::latest('created_at')->paginate(15);
        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        $profesores = Usuario::where('rol','profesor')->get();
        return view('eventos.create', compact('profesores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_evento' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'cupo_maximo' => 'required|integer|min:1',
            'lugar' => 'nullable|string|max:100',
            'id_profesor' => 'nullable|exists:usuarios,id_usuario',
            'creado_por' => 'nullable|exists:usuarios,id_usuario',
        ]);

        $data['cupo_disponible'] = $data['cupo_maximo'];
        $evento = Evento::create($data);

        return redirect()->route('eventos.index')->with('success', 'Evento creado.');
    }

    public function show(Evento $evento)
    {
        $evento->load('inscripciones.usuario');
        return view('eventos.show', compact('evento'));
    }

    public function edit(Evento $evento)
    {
        $profesores = Usuario::where('rol','profesor')->get();
        return view('eventos.edit', compact('evento','profesores'));
    }

    public function update(Request $request, Evento $evento)
    {
        $data = $request->validate([
            'nombre_evento' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'cupo_maximo' => 'required|integer|min:1',
            'lugar' => 'nullable|string|max:100',
            'id_profesor' => 'nullable|exists:usuarios,id_usuario',
        ]);

        $inscritas = $evento->inscripciones()->count();
        $data['cupo_disponible'] = max(0, $data['cupo_maximo'] - $inscritas);

        $evento->update($data);

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento eliminado.');
    }
}
