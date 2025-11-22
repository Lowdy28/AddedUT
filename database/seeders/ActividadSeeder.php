<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actividad;

class ActividadSeeder extends Seeder
{
    public function run(): void
    {
        $actividades = [
            ['nombre' => 'Fútbol Soccer', 'descripcion' => 'Entrenamientos y torneos internos de fútbol.', 'categoria' => 'Deportivo', 'cupos' => 40],
            ['nombre' => 'Danza Moderna', 'descripcion' => 'Taller de baile para presentaciones culturales.', 'categoria' => 'Cultural', 'cupos' => 30],
            ['nombre' => 'Ajedrez', 'descripcion' => 'Club dirigido al desarrollo mental y estrategia.', 'categoria' => 'Académico', 'cupos' => 25],
            ['nombre' => 'Taekwondo', 'descripcion' => 'Disciplina deportiva y marcial para competencias.', 'categoria' => 'Deportivo', 'cupos' => 35],
        ];

        foreach ($actividades as $actividad) {
            Actividad::create($actividad);
        }
    }
}
