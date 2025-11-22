<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Evento;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    public function index()
    {
        $inscripciones = Inscripcion::with(['usuario','evento'])->orderBy('fecha_inscripcion','desc')->paginate(20);
        return view('inscripciones.index', compact('inscripciones'));
    }

    public function create()
    {
        $usuarios = Usuario::where('activo', true)->get();
        $eventos = Evento::where('fecha_fin','>=', now()->toDateString())->get();
        return view('inscripciones.create', compact('usuarios','eventos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_evento' => 'required|exists:eventos,id_evento',
        ]);

        DB::beginTransaction();
        try {
            $evento = Evento::lockForUpdate()->find($data['id_evento']);

            if (!$evento) {
                DB::rollBack();
                return back()->withErrors('Evento no encontrado.');
            }

            if ($evento->cupo_disponible <= 0) {
                DB::rollBack();
                return back()->withErrors('No hay cupo disponible en este evento.');
            }

            // Checar si ya está inscrito
            $exists = Inscripcion::where('id_usuario', $data['id_usuario'])
                        ->where('id_evento', $data['id_evento'])
                        ->exists();

            if ($exists) {
                DB::rollBack();
                return back()->withErrors('El usuario ya está inscrito en este evento.');
            }

            // Crear inscripcion
            $ins = Inscripcion::create([
                'id_usuario' => $data['id_usuario'],
                'id_evento' => $data['id_evento'],
                'estado' => 'confirmada'
            ]);

            $evento->decrement('cupo_disponible', 1);

            DB::commit();

            return redirect()->route('inscripciones.index')->with('success', 'Inscripción realizada.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Error al inscribir: ' . $e->getMessage());
        }
    }

    public function show(Inscripcion $inscripcion)
    {
        $inscripcion->load(['usuario','evento']);
        return view('inscripciones.show', compact('inscripcion'));
    }

    public function edit(Inscripcion $inscripcion)
    {
        $usuarios = Usuario::where('activo', true)->get();
        $eventos = Evento::all();
        return view('inscripciones.edit', compact('inscripcion','usuarios','eventos'));
    }

    public function update(Request $request, Inscripcion $inscripcion)
    {
        $data = $request->validate([
            'estado' => 'required|string|max:20',
        ]);

        $inscripcion->update($data);

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción actualizada.');
    }

    public function destroy(Inscripcion $inscripcion)
    {
        DB::transaction(function () use ($inscripcion) {
            $evento = Evento::lockForUpdate()->find($inscripcion->id_evento);
            if ($evento) {
                $evento->increment('cupo_disponible', 1);
            }
            $inscripcion->delete();
        });

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada.');
    }
}
