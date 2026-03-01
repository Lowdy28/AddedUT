<?php

namespace App\Http\Controllers;

use App\Models\UserInteres;
use App\Services\RecomendacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecomendacionController extends Controller
{
    public function __construct(private RecomendacionService $servicio) {}

    public function guardarIntereses(Request $request)
    {
        $request->validate([
            'tipo_actividad'    => 'required|in:arte,deporte,cultura,mente',
            'modalidad'         => 'required|in:individual,equipo',
            'experiencia'       => 'required|in:ninguna,poca,mucha',
            'horario_preferido' => 'required|in:manana,tarde',
            'objetivo'          => 'required|in:competir,aprender,relajarse,socializar',
        ]);

        $interes = UserInteres::updateOrCreate(
            ['id_usuario' => Auth::id()],
            [
                'tipo_actividad'          => $request->tipo_actividad,
                'modalidad'               => $request->modalidad,
                'experiencia'             => $request->experiencia,
                'horario_preferido'       => $request->horario_preferido,
                'objetivo'                => $request->objetivo,
                'cuestionario_completado' => true,
            ]
        );

        $interes->tipo_actividad_extra = $request->input('tipo_actividad_extra', [$request->tipo_actividad]);
        $interes->objetivos            = $request->input('objetivos', [$request->objetivo]);

        $recomendaciones = $this->servicio->recomendar($interes);
        $this->servicio->guardarLog(Auth::id(), $recomendaciones);

        $resultado = collect($recomendaciones)->map(fn($item) => [
            'id'          => $item['evento']->id_evento,
            'nombre'      => $item['evento']->nombre,
            'categoria'   => $item['evento']->categoria,
            'descripcion' => $item['evento']->descripcion,
            'imagen_url'  => $item['evento']->imagen_url,
            'horario'     => $item['evento']->horario,
            'lugar'       => $item['evento']->lugar ?? 'Campus UTTEC',
            'cupos'       => $item['evento']->cupo_disponible,
            'score'       => $item['score'],
            'url'         => route('estudiante.eventos.show', $item['evento']->id_evento),
        ]);

        return response()->json([
            'success'          => true,
            'recomendaciones'  => $resultado,
        ]);
    }

    public function omitir()
    {
        UserInteres::updateOrCreate(
            ['id_usuario' => Auth::id()],
            ['cuestionario_completado' => true]
        );

        return response()->json(['success' => true]);
    }
}
