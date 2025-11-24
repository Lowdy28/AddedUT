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
        $inscripciones = Inscripcion::with(['usuario','evento'])
            ->orderBy('fecha_inscripcion','desc')
            ->paginate(20);

        // 🔥 NECESARIO PARA LOS MODALES (create y edit)
        $usuarios = Usuario::where('activo', true)->get();
        $eventos = Evento::all();

        return view('inscripciones.index', compact('inscripciones','usuarios','eventos'));
    }

    public function create()
    {
        // (Puedes dejarlo así aunque no lo uses si los modales están en index)
        $usuarios = Usuario::where('activo', true)->get();
        $eventos = Evento::all();

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

            $exists = Inscripcion::where('id_usuario', $data['id_usuario'])
                        ->where('id_evento', $data['id_evento'])
                        ->exists();

            if ($exists) {
                DB::rollBack();
                return back()->withErrors('El usuario ya está inscrito en este evento.');
            }

            Inscripcion::create([
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

    // 🔥 MODIFICADO SEGÚN TU SOLICITUD
    public function show(Inscripcion $inscripcion)
    {
        return redirect()->route('inscripciones.index');
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

    public function updateEstado(Request $request, $id)
{
    $request->validate([
        'estado' => 'required|string|max:20'
    ]);

    $inscripcion = Inscripcion::find($id);

    if (!$inscripcion) {
        return response()->json([
            'success' => false,
            'message' => 'Inscripción no encontrada.'
        ], 404);
    }

    $inscripcion->estado = $request->estado;
    $inscripcion->save();

    return response()->json([
        'success' => true,
        'message' => 'Estado actualizado correctamente.',
        'data' => $inscripcion
    ]);
}

}
