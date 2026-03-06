<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Inscripcion;
use App\Models\User;
use App\Notifications\CambioHorarioNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GestionAlumnoController extends Controller
{
    /**
     * Verifica que el profesor sea dueño del taller.
     */
    private function verificarProfesor(Evento $evento)
    {
        if ($evento->creado_por !== Auth::id()) {
            abort(403, 'No autorizado.');
        }
    }

    /**
     * Da de baja a un alumno del taller.
     * Cambia estado a 'baja' y notifica al alumno.
     */
    public function darDeBaja(Request $request, Evento $evento, $idUsuario)
    {
        $this->verificarProfesor($evento);

        $inscripcion = Inscripcion::where('id_evento', $evento->id_evento)
            ->where('id_usuario', $idUsuario)
            ->firstOrFail();

        // Cambiar estado a baja (sin eliminar — conserva historial de asistencia)
        $inscripcion->update(['estado' => 'baja']);

        // Notificar al alumno
        $alumno = User::find($idUsuario);
        if ($alumno) {
            $alumno->notify(new CambioHorarioNotification([
                'titulo'  => 'Baja del taller: ' . $evento->nombre,
                'mensaje' => 'El profesor te ha dado de baja del taller ' . $evento->nombre . '.',
                'tipo'    => 'baja',
                'url'     => route('estudiante.eventos.index'),
            ]));
        }

        return response()->json([
            'message' => 'Alumno dado de baja correctamente.',
            'alumno'  => $alumno?->nombre,
        ]);
    }

    /**
     * Reactiva un alumno que estaba de baja.
     */
    public function reactivar(Request $request, Evento $evento, $idUsuario)
    {
        $this->verificarProfesor($evento);

        $inscripcion = Inscripcion::where('id_evento', $evento->id_evento)
            ->where('id_usuario', $idUsuario)
            ->firstOrFail();

        $inscripcion->update(['estado' => 'confirmada']);

        $alumno = User::find($idUsuario);
        if ($alumno) {
            $alumno->notify(new CambioHorarioNotification([
                'titulo'  => 'Reactivación en taller: ' . $evento->nombre,
                'mensaje' => 'Tu inscripción en el taller ' . $evento->nombre . ' ha sido reactivada.',
                'tipo'    => 'inscripcion',
                'url'     => route('estudiante.eventos.index'),
            ]));
        }

        return response()->json([
            'message' => 'Alumno reactivado correctamente.',
        ]);
    }

    /**
     * Guarda o actualiza la nota/observación del profesor sobre un alumno.
     */
    public function guardarNota(Request $request, Evento $evento, $idUsuario)
    {
        $this->verificarProfesor($evento);

        $request->validate([
            'nota' => 'nullable|string|max:500',
        ]);

        $inscripcion = Inscripcion::where('id_evento', $evento->id_evento)
            ->where('id_usuario', $idUsuario)
            ->firstOrFail();

        $inscripcion->update(['nota' => $request->nota]);

        return response()->json([
            'message' => 'Nota guardada correctamente.',
            'nota'    => $inscripcion->nota,
        ]);
    }

    /**
     * Devuelve los datos completos de un alumno (para abrir el modal).
     */
    public function datosAlumno(Evento $evento, $idUsuario)
    {
        $this->verificarProfesor($evento);

        $inscripcion = Inscripcion::where('id_evento', $evento->id_evento)
            ->where('id_usuario', $idUsuario)
            ->with('usuario')
            ->firstOrFail();

        // Historial de asistencia resumido
        $asistencias = \App\Models\Asistencia::where('id_evento', $evento->id_evento)
            ->where('id_usuario', $idUsuario)
            ->orderBy('fecha', 'desc')
            ->get();

        $totalSesiones = $asistencias->count();
        $presentes     = $asistencias->where('estado', 'presente')->count();
        $pct           = $totalSesiones > 0 ? round($presentes / $totalSesiones * 100) : null;

        return response()->json([
            'id_usuario'       => $inscripcion->id_usuario,
            'nombre'           => $inscripcion->usuario->nombre,
            'email'            => $inscripcion->usuario->email,
            'matricula'        => $inscripcion->usuario->matricula ?? '—',
            'foto'             => $inscripcion->usuario->foto
                                    ? asset('storage/' . $inscripcion->usuario->foto)
                                    : null,
            'estado'           => $inscripcion->estado,
            'nota'             => $inscripcion->nota ?? '',
            'fecha_inscripcion'=> $inscripcion->fecha_inscripcion,
            'asistencia_pct'   => $pct,
            'sesiones_total'   => $totalSesiones,
            'sesiones_presente'=> $presentes,
        ]);
    }
}
