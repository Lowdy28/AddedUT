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
        
        // Traer todos los eventos (sin filtro de fecha para evitar el error)
        $eventos = Evento::all();

        return view('inscripciones.index', compact('inscripciones','usuarios','eventos'));
    }

    public function create()
    {
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

            // Verificar cupo disponible
            if ($evento->cupos <= 0) {
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
            Inscripcion::create([
                'id_usuario' => $data['id_usuario'],
                'id_evento' => $data['id_evento'],
                'estado' => 'confirmada'
            ]);

            // Decrementar cupo
            $evento->decrement('cupos', 1);

            DB::commit();

            return redirect()->route('inscripciones.index')->with('success', 'Inscripción realizada.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Error al inscribir: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $inscripcion = Inscripcion::with(['usuario','evento'])->findOrFail($id);
        return view('inscripciones.show', compact('inscripcion'));
    }

    public function edit($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $usuarios = Usuario::where('activo', true)->get();
        $eventos = Evento::all();
        return view('inscripciones.edit', compact('inscripcion','usuarios','eventos'));
    }

    public function update(Request $request, $id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        
        $data = $request->validate([
            'estado' => 'required|string|in:confirmada,pendiente,cancelada',
        ]);

        $inscripcion->estado = $data['estado'];
        $inscripcion->save();

        return redirect()->route('inscripciones.index')->with('success', 'Estado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        
        DB::transaction(function () use ($inscripcion) {
            $evento = Evento::lockForUpdate()->find($inscripcion->id_evento);
            
            // Incrementar cupo al eliminar inscripción
            if ($evento) {
                $evento->increment('cupos', 1);
            }
            
            $inscripcion->delete();
        });

        return redirect()->route('inscripciones.index')->with('success', 'Inscripción eliminada.');
    }
}