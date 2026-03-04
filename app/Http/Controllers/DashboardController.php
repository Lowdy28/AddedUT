<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Evento;
use App\Models\Inscripcion;
use App\Models\Noticia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('dashboard.admin');
    }

    public function admin()
    {
        // ── KPIs ────────────────────────────────────────────────
        $totalUsuarios      = Usuario::count();
        $totalEstudiantes   = Usuario::where('rol', 'estudiante')->count();
        $totalProfesores    = Usuario::where('rol', 'profesor')->count();
        $totalEventos       = Evento::count();
        $totalInscripciones = Inscripcion::count();
        $totalNoticias      = Noticia::count();

        // Nuevos usuarios este mes
        $nuevosEsteMes = Usuario::whereMonth('fecha_registro', Carbon::now()->month)
            ->whereYear('fecha_registro', Carbon::now()->year)
            ->count();

        // ── Inscripciones por mes (últimos 6 meses) ──────────────
        $inscripcionesPorMes = Inscripcion::select(
                DB::raw("DATE_FORMAT(fecha_inscripcion, '%b %Y') as mes"),
                DB::raw("DATE_FORMAT(fecha_inscripcion, '%Y-%m') as mes_orden"),
                DB::raw('count(*) as total')
            )
            ->where('fecha_inscripcion', '>=', Carbon::now()->subMonths(6))
            ->groupBy('mes', 'mes_orden')
            ->orderBy('mes_orden')
            ->get();

        // ── Talleres con más inscripciones ───────────────────────
        $topTalleres = Evento::select('eventos.nombre', DB::raw('count(inscripciones.id_inscripcion) as total'))
            ->leftJoin('inscripciones', 'eventos.id_evento', '=', 'inscripciones.id_evento')
            ->groupBy('eventos.id_evento', 'eventos.nombre')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // ── Inscripciones recientes ──────────────────────────────
        $inscripcionesRecientes = Inscripcion::with(['usuario', 'evento'])
            ->orderByDesc('fecha_inscripcion')
            ->limit(8)
            ->get();

        // ── Eventos próximos ─────────────────────────────────────
        $eventosProximos = Evento::where('fecha_inicio', '>=', Carbon::now())
            ->orderBy('fecha_inicio')
            ->limit(5)
            ->get();

        // ── Distribución por categoría ───────────────────────────
        $eventosPorCategoria = Evento::select('categoria', DB::raw('count(*) as total'))
            ->groupBy('categoria')
            ->get();

        // ── Porcentaje ocupación general ─────────────────────────
        $cuposTotales     = Evento::sum('cupos') ?: 1;
        $cuposDisponibles = Evento::sum('cupo_disponible');
        $ocupacion        = round((($cuposTotales - $cuposDisponibles) / $cuposTotales) * 100);

        return view('dashboard', compact(
            'totalUsuarios', 'totalEstudiantes', 'totalProfesores',
            'totalEventos', 'totalInscripciones', 'totalNoticias',
            'nuevosEsteMes', 'inscripcionesPorMes', 'topTalleres',
            'inscripcionesRecientes', 'eventosProximos',
            'eventosPorCategoria', 'ocupacion'
        ));
    }
}
