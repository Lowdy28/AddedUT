<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscripcion;
use App\Models\Evento;
use App\Services\RecomendacionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class InscripcionController extends Controller
{
    public function __construct(private RecomendacionService $servicio) {}

    public function index()
    {
        $inscripciones = Inscripcion::with(['usuario','evento'])
            ->orderBy('fecha_inscripcion','desc')
            ->paginate(20);

        $usuarios = \App\Models\Usuario::where('activo', true)->get();
        $eventos  = Evento::all();

        return view('inscripciones.index', compact('inscripciones','usuarios','eventos'));
    }

    public function create()
    {
        $usuarios = \App\Models\Usuario::where('activo', true)->get();
        $eventos  = Evento::all();
        return view('inscripciones.create', compact('usuarios','eventos'));
    }

   public function store(Request $request, Evento $evento = null)
{
    $eventoParaInscribir = $evento ?? Evento::findOrFail($request->input('id_evento'));
    $eventId = $eventoParaInscribir->id_evento;
    $userId = Auth::id();

    if (!$userId) {
        return back()->with('error', 'Error de Autenticación: Debes iniciar sesión para inscribirte.');
    }

    $existeInscripcion = Inscripcion::where('id_usuario', $userId)
                                   ->where('id_evento', $eventId)
                                   ->exists();

    if ($existeInscripcion) {
        return back()->with('error', 'Ya estás inscrito en este evento.');
    }

    if (($eventoParaInscribir->cupo_disponible ?? 0) <= 0) {
        return back()->with('error', 'Lo sentimos, los cupos para este evento se han agotado.');
    }

    try {
        DB::beginTransaction();

        $inscripcion = Inscripcion::create([
            'id_usuario'        => $userId,
            'id_evento'         => $eventId,
            'estado'            => 'confirmada',
            'fecha_inscripcion' => Carbon::now()
        ]);

        $eventoParaInscribir->decrement('cupo_disponible');

        DB::commit();

        $inscripcion->load('evento');
        $inscripcion->fireModelEvent('created', false);

        return redirect()->route('estudiante.eventos.show', $eventoParaInscribir->id_evento)
                         ->with('success', '¡Inscripción exitosa! El cupo ha sido reservado.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'FALLO CRÍTICO (DB/Lógica): ' . $e->getMessage());
    }
}

    public function destroyByEvent(Evento $evento)
    {
        $userId = Auth::id();

        $inscripcion = Inscripcion::where('id_usuario', $userId)
                                  ->where('id_evento', $evento->id_evento)
                                  ->first();

        if (!$inscripcion) {
            return back()->with('error', 'No estás inscrito en este evento.');
        }

        try {
            DB::beginTransaction();

            $inscripcion->delete();
            $evento->increment('cupo_disponible');

            DB::commit();

            return redirect()->route('estudiante.eventos.show', $evento->id_evento)
                             ->with('success', 'Inscripción cancelada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al cancelar la inscripción: ' . $e->getMessage());
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
        $usuarios    = \App\Models\Usuario::where('activo', true)->get();
        $eventos     = Evento::all();
        return view('inscripciones.edit', compact('inscripcion','usuarios','eventos'));
    }

    public function update(Request $request, $id)
    {
        $inscripcion = Inscripcion::findOrFail($id);
        $data        = $request->validate([
            'estado' => 'required|string'
        ]);

        $inscripcion->update($data);

        return redirect()->route('inscripciones.index')
                         ->with('success', 'Estado actualizado.');
    }

    public function destroy($id)
    {
        $inscripcion = Inscripcion::findOrFail($id);

        DB::transaction(function () use ($inscripcion) {
            $evento = Evento::lockForUpdate()->find($inscripcion->id_evento);
            if ($evento) {
                $evento->increment('cupo_disponible');
            }
            $inscripcion->delete();
        });

        return redirect()->route('inscripciones.index')
                         ->with('success', 'Inscripción eliminada.');
    }
}