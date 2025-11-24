<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\Usuario;
use Carbon\Carbon;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $profesores = Usuario::where('rol', 'profesor')->get();

        if ($profesores->isEmpty()) {
            $this->command->info('No hay profesores para asignar eventos. Seeder omitido.');
            return;
        }

        $eventos = [
            ['nombre' => 'Bailes de Salón', 'categoria' => 'Cultural'],
            ['nombre' => 'Música', 'categoria' => 'Cultural'],
            ['nombre' => 'Oratoria y Dibujo', 'categoria' => 'Cultural'],
            ['nombre' => 'Teatro', 'categoria' => 'Cultural'],

            ['nombre' => 'Ajedrez', 'categoria' => 'Deportivo'],
            ['nombre' => 'Basquetbol', 'categoria' => 'Deportivo'],
            ['nombre' => 'Fútbol americano', 'categoria' => 'Deportivo'],
            ['nombre' => 'Fútbol rápido y 7', 'categoria' => 'Deportivo'],
            ['nombre' => 'Fútbol soccer', 'categoria' => 'Deportivo'],
            ['nombre' => 'Taekwondo', 'categoria' => 'Deportivo'],
            ['nombre' => 'Voleibol', 'categoria' => 'Deportivo'],
        ];

        foreach ($eventos as $evento) {
            Evento::create([
                'nombre'        => $evento['nombre'],
                'descripcion'   => "Descripción de {$evento['nombre']}",
                'categoria'     => $evento['categoria'],
                'cupos'         => rand(10, 50),
                'creado_por'    => $profesores->random()->id_usuario,
                'fecha_inicio'  => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                'fecha_fin'     => Carbon::now()->addDays(rand(31, 90))->format('Y-m-d'),
            ]);
        }

        $this->command->info('Eventos creados exitosamente.');
    }
}
