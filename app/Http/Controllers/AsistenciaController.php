<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Evento;
use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * Devuelve la lista de asistencia de un taller para una fecha dada.
     * Si aún no hay registros para esa fecha, devuelve los alumnos inscritos
     * con estado null (sin registrar).
     */
    public function porFecha(Request $request, Evento $evento)
    {
        // Solo el profesor dueño del taller puede ver esto
        if ($evento->creado_por !== Auth::id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        $fecha = $request->query('fecha', today()->toDateString());

        // Alumnos inscritos
        $inscritos = Inscripcion::where('id_evento', $evento->id_evento)
            ->with('usuario')
            ->get();

        // Asistencias ya registradas para esa fecha
        $registradas = Asistencia::where('id_evento', $evento->id_evento)
            ->where('fecha', $fecha)
            ->get()
            ->keyBy('id_usuario');

        $lista = $inscritos->map(function ($ins) use ($registradas) {
            $reg = $registradas->get($ins->id_usuario);
            return [
                'id_usuario' => $ins->id_usuario,
                'nombre'     => $ins->usuario->nombre ?? 'Sin nombre',
                'matricula'  => $ins->usuario->matricula ?? '—',
                'foto'       => $ins->usuario->foto
                                    ? asset('storage/' . $ins->usuario->foto)
                                    : null,
                'estado'     => $reg?->estado ?? null,
                'nota'       => $reg?->nota   ?? '',
            ];
        });

        return response()->json([
            'fecha'  => $fecha,
            'lista'  => $lista,
        ]);
    }

    /**
     * Guarda o actualiza la asistencia de todos los alumnos de una sesión.
     */
    public function guardar(Request $request, Evento $evento)
    {
        if ($evento->creado_por !== Auth::id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        $request->validate([
            'fecha'               => 'required|date',
            'asistencias'         => 'required|array',
            'asistencias.*.id_usuario' => 'required|integer',
            'asistencias.*.estado'     => 'required|in:presente,ausente,justificado',
            'asistencias.*.nota'       => 'nullable|string|max:255',
        ]);

        foreach ($request->asistencias as $item) {
            Asistencia::updateOrCreate(
                [
                    'id_evento'  => $evento->id_evento,
                    'id_usuario' => $item['id_usuario'],
                    'fecha'      => $request->fecha,
                ],
                [
                    'estado' => $item['estado'],
                    'nota'   => $item['nota'] ?? null,
                ]
            );
        }

        return response()->json(['message' => 'Asistencia guardada correctamente.']);
    }

    /**
     * Devuelve el historial completo de asistencia de un alumno en el taller.
     */
    public function historial(Evento $evento, $idUsuario)
    {
        if ($evento->creado_por !== Auth::id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        $registros = Asistencia::where('id_evento', $evento->id_evento)
            ->where('id_usuario', $idUsuario)
            ->orderBy('fecha', 'desc')
            ->get(['fecha', 'estado', 'nota']);

        $total     = $registros->count();
        $presentes = $registros->where('estado', 'presente')->count();
        $porcentaje = $total > 0 ? round(($presentes / $total) * 100) : 0;

        return response()->json([
            'registros'  => $registros,
            'total'      => $total,
            'presentes'  => $presentes,
            'porcentaje' => $porcentaje,
        ]);
    }

    /**
     * Genera y descarga el PDF de asistencia de una sesión.
     */
    public function exportPdf(Request $request, Evento $evento)
    {
        if ($evento->creado_por !== Auth::id()) {
            abort(403);
        }

        $fecha = $request->query('fecha', today()->toDateString());

        // Alumnos inscritos
        $inscritos = Inscripcion::where('id_evento', $evento->id_evento)
            ->with('usuario')
            ->get();

        // Asistencias registradas para esa fecha
        $registradas = Asistencia::where('id_evento', $evento->id_evento)
            ->where('fecha', $fecha)
            ->get()
            ->keyBy('id_usuario');

        $lista = $inscritos->map(function ($ins) use ($registradas) {
            $reg = $registradas->get($ins->id_usuario);
            return (object)[
                'nombre'   => $ins->usuario->nombre ?? 'Sin nombre',
                'matricula'=> $ins->usuario->matricula ?? null,
                'estado'   => $reg?->estado ?? null,
                'nota'     => $reg?->nota ?? null,
            ];
        });

        $evento->load('creador');

        $pdf = Pdf::loadView('profesor.asistencia-pdf', [
            'taller' => $evento,
            'fecha'  => $fecha,
            'lista'  => $lista,
        ])->setPaper('a4', 'portrait');

        $nombreArchivo = 'asistencia_' . str_replace(' ', '_', $evento->nombre) . '_' . $fecha . '.pdf';

        return $pdf->download($nombreArchivo);
    }

}
