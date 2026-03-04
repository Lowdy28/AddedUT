<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Actividad;
use App\Models\Evento;
use App\Models\Inscripcion;
use App\Models\Noticia;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\UsuariosExport;
use App\Exports\ActividadesExport;
use App\Exports\EventosExport;
use App\Exports\InscripcionesExport;
use App\Exports\NoticiasExport;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $totalUsuarios      = Usuario::count();
        $totalProfesores    = Usuario::where('rol', 'profesor')->count();
        $totalEstudiantes   = Usuario::where('rol', 'estudiante')->count();
        $totalAdmins        = Usuario::where('rol', 'admin')->count();
        $totalActividades   = Actividad::count();
        $totalEventos       = Evento::count();
        $totalInscripciones = Inscripcion::count();
        $totalNoticias      = Noticia::count();

        return view('reportes.dashboard', compact(
            'totalUsuarios', 'totalProfesores', 'totalEstudiantes', 'totalAdmins',
            'totalActividades', 'totalEventos', 'totalInscripciones', 'totalNoticias'
        ));
    }

    // ── AJAX: datos para gráficas y tablas ──────────────────────────────────

    public function usuariosData(Request $request)
    {
        $query = Usuario::query();
        if ($role  = $request->query('rol'))    $query->where('rol', $role);
        if ($activo = $request->query('activo')) $query->where('activo', $activo);

        $users       = $query->select('id_usuario','nombre','email','rol','activo','fecha_registro')->paginate(25);
        $byRole      = Usuario::select('rol', DB::raw('count(*) as total'))->groupBy('rol')->get();
        $activeCount   = Usuario::where('activo', 1)->count();
        $inactiveCount = Usuario::where('activo', 0)->count();

        return response()->json([
            'table'    => $users,
            'byRole'   => $byRole,
            'active'   => $activeCount,
            'inactive' => $inactiveCount,
        ]);
    }

    public function actividadesData(Request $request)
    {
        $actividades = Actividad::select('id_actividad','nombre','descripcion','categoria','cupos')->paginate(25);
        $byCategory  = Actividad::select('categoria', DB::raw('count(*) as total'))->groupBy('categoria')->get();
        return response()->json(['table' => $actividades, 'byCategory' => $byCategory]);
    }

    public function eventosData(Request $request)
    {
        $eventos    = Evento::with('profesor')
            ->select('id_evento','nombre','categoria','cupos','fecha_inicio','fecha_fin','creado_por')
            ->paginate(25);
        $byCategory = Evento::select('categoria', DB::raw('count(*) as total'))->groupBy('categoria')->get();
        $porMes     = Evento::select(
                DB::raw("DATE_FORMAT(fecha_inicio,'%Y-%m') as mes"),
                DB::raw('count(*) as total')
            )->groupBy('mes')->orderBy('mes')->get();

        return response()->json(['table' => $eventos, 'byCategory' => $byCategory, 'porMes' => $porMes]);
    }

    public function inscripcionesData(Request $request)
    {
        $inscripciones = Inscripcion::with(['usuario','evento'])->paginate(25);
        $porEvento     = Inscripcion::select('id_evento', DB::raw('count(*) as total'))
            ->groupBy('id_evento')->get();

        return response()->json(['table' => $inscripciones, 'porEvento' => $porEvento]);
    }

    public function noticiasData(Request $request)
    {
        $noticias   = Noticia::with('autor')
            ->select('id_noticia','titulo','categoria','publicada','publicado_por','created_at')
            ->paginate(25);
        $byCategory = Noticia::select('categoria', DB::raw('count(*) as total'))->groupBy('categoria')->get();
        $publicadas = Noticia::where('publicada', 1)->count();
        $borradores = Noticia::where('publicada', 0)->count();

        return response()->json([
            'table'      => $noticias,
            'byCategory' => $byCategory,
            'publicadas' => $publicadas,
            'borradores' => $borradores,
        ]);
    }

    // ── Exportar Excel / PDF ─────────────────────────────────────────────────

    public function export(Request $request, $tipo, $formato)
    {
        $formato = strtolower($formato);

        $map = [
            'usuarios'      => UsuariosExport::class,
            'actividades'   => ActividadesExport::class,
            'eventos'       => EventosExport::class,
            'inscripciones' => InscripcionesExport::class,
            'noticias'      => NoticiasExport::class,
        ];

        if (!isset($map[$tipo])) abort(404, 'Tipo de reporte no válido.');

        $exportClass = $map[$tipo];

        if (in_array($formato, ['excel', 'xlsx', 'csv'])) {
            return Excel::download(new $exportClass, "{$tipo}_" . now()->format('Ymd') . ".xlsx");
        }

        if ($formato === 'pdf') {
            $data     = (new $exportClass)->collection();
            $viewName = 'reportes.exports.' . $tipo;
            $pdf      = Pdf::loadView($viewName, ['rows' => $data])
                ->setPaper('a4', 'landscape');
            return $pdf->download("{$tipo}_" . now()->format('Ymd') . ".pdf");
        }

        abort(400, 'Formato no soportado.');
    }
}
