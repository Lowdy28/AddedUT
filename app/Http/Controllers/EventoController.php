<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $eventos = Evento::with('creador')
            ->when($buscar, function ($q) use ($buscar) {
                $q->where('nombre', 'like', "%$buscar%")
                  ->orWhere('categoria', 'like', "%$buscar%");
            })
            ->orderBy('fecha_inicio', 'asc')
            ->paginate(15);

        return view('eventos.index', compact('eventos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'cupos' => 'required|integer|min:1',
        ]);

        $evento = Evento::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? 'Sin descripción',
            'categoria' => $data['categoria'] ?? 'General',
            'cupos' => $data['cupos'],
            'creado_por' => Auth::id(),
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
        ]);

        return response()->json(['message' => 'Evento creado correctamente']);
    }

    public function show(Evento $evento)
    {
        return view('eventos.show', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'categoria' => 'nullable|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'cupos' => 'required|integer|min:1',
        ]);

        $evento->update([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? 'Sin descripción',
            'categoria' => $data['categoria'] ?? 'General',
            'cupos' => $data['cupos'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
        ]);

        return response()->json(['message' => 'Evento actualizado correctamente']);
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return response()->json(['message' => 'Evento eliminado correctamente']);
    }
}