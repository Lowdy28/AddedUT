<?php

namespace App\Services;

use App\Models\Evento;
use App\Models\RecomendacionLog;
use App\Models\UserInteres;

class RecomendacionService
{
    private array $mapaCategoriaActividad = [
        'Deportivo' => 'deporte',
        'Cultural'  => 'arte',
        'Académico' => 'mente',
    ];

    private array $mapaModalidad = [
        'Basquetbol'        => 'equipo',
        'Fútbol americano'  => 'equipo',
        'Fútbol rápido y 7' => 'equipo',
        'Fútbol soccer'     => 'equipo',
        'Voleibol'          => 'equipo',
        'Bailes de Salón'   => 'equipo',
        'Teatro'            => 'equipo',
        'Taekwondo'         => 'individual',
        'Ajedrez'           => 'individual',
        'Música'            => 'individual',
        'Oratoria y Dibujo' => 'individual',
    ];

    private array $mapaObjetivo = [
        'Basquetbol'        => ['competir', 'socializar'],
        'Fútbol americano'  => ['competir', 'socializar'],
        'Fútbol rápido y 7' => ['competir', 'socializar'],
        'Fútbol soccer'     => ['competir', 'socializar'],
        'Voleibol'          => ['competir', 'socializar'],
        'Taekwondo'         => ['competir', 'aprender'],
        'Ajedrez'           => ['aprender', 'relajarse'],
        'Música'            => ['aprender', 'relajarse'],
        'Bailes de Salón'   => ['aprender', 'socializar'],
        'Teatro'            => ['aprender', 'socializar'],
        'Oratoria y Dibujo' => ['aprender', 'relajarse'],
    ];

    private array $mapaExperiencia = [
        'Taekwondo'         => 'poca',
        'Ajedrez'           => 'poca',
        'Fútbol americano'  => 'poca',
        'Basquetbol'        => 'ninguna',
        'Fútbol rápido y 7' => 'ninguna',
        'Fútbol soccer'     => 'ninguna',
        'Voleibol'          => 'ninguna',
        'Bailes de Salón'   => 'ninguna',
        'Música'            => 'ninguna',
        'Teatro'            => 'ninguna',
        'Oratoria y Dibujo' => 'ninguna',
    ];

    public function recomendar(UserInteres $interes, int $limite = 3): array
    {
        $eventos = Evento::where('cupo_disponible', '>', 0)->get();

        $tiposActividad = property_exists($interes, 'tipo_actividad_extra') && is_array($interes->tipo_actividad_extra)
            ? $interes->tipo_actividad_extra
            : [$interes->tipo_actividad];

        $objetivos = property_exists($interes, 'objetivos') && is_array($interes->objetivos)
            ? $interes->objetivos
            : [$interes->objetivo];

        $puntuados = $eventos->map(function (Evento $evento) use ($interes, $tiposActividad, $objetivos) {
            $score = 0;

            $categoriaEvento = $this->mapaCategoriaActividad[$evento->categoria] ?? null;
            if ($categoriaEvento && in_array($categoriaEvento, $tiposActividad)) {
                $score += 40;
            }

            $modalidadEvento = $this->mapaModalidad[$evento->nombre] ?? null;
            if ($modalidadEvento === $interes->modalidad) {
                $score += 20;
            }

            $objetivosEvento = $this->mapaObjetivo[$evento->nombre] ?? [];
            $coincidencias   = count(array_intersect($objetivos, $objetivosEvento));
            $score += $coincidencias * 10;

            $experienciaRequerida = $this->mapaExperiencia[$evento->nombre] ?? 'ninguna';
            $nivelMap = ['ninguna' => 0, 'poca' => 1, 'mucha' => 2];
            $nivelEstudiante = $nivelMap[$interes->experiencia] ?? 0;
            $nivelRequerido  = $nivelMap[$experienciaRequerida] ?? 0;

            if ($nivelEstudiante >= $nivelRequerido) {
                $score += 15;
            }

            if ($evento->cupo_disponible <= 5) {
                $score -= 10;
            }

            return [
                'evento' => $evento,
                'score'  => min(100, max(0, $score)),
            ];
        });

        $top = $puntuados
            ->sortByDesc('score')
            ->take($limite)
            ->values();

        return $top->all();
    }

    public function guardarLog(int $idUsuario, array $recomendaciones): void
    {
        RecomendacionLog::where('id_usuario', $idUsuario)->delete();

        foreach ($recomendaciones as $posicion => $item) {
            RecomendacionLog::create([
                'id_usuario' => $idUsuario,
                'id_evento'  => $item['evento']->id_evento,
                'score'      => $item['score'],
                'posicion'   => $posicion + 1,
                'inscrito'   => null,
            ]);
        }
    }

    public function marcarInscrito(int $idUsuario, int $idEvento): void
    {
        RecomendacionLog::where('id_usuario', $idUsuario)
            ->where('id_evento', $idEvento)
            ->update(['inscrito' => true]);

        RecomendacionLog::where('id_usuario', $idUsuario)
            ->where('id_evento', '!=', $idEvento)
            ->whereNull('inscrito')
            ->update(['inscrito' => false]);
    }
}
