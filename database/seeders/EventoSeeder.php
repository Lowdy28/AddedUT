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

        $talleres = [
            ['nombre' => 'Música para todos', 'categoria' => 'Cultural'],
            ['nombre' => 'Taller de Teatro', 'categoria' => 'Cultural'],
            ['nombre' => 'Clases de Dibujo', 'categoria' => 'Cultural'],
            ['nombre' => 'Baile Contemporáneo', 'categoria' => 'Cultural'],
            ['nombre' => 'Fotografía Creativa', 'categoria' => 'Cultural'],
            ['nombre' => 'Coro Comunitario', 'categoria' => 'Cultural'],
            ['nombre' => 'Yoga y Bienestar', 'categoria' => 'Deportivo'],
            ['nombre' => 'Taekwondo Infantil', 'categoria' => 'Deportivo'],
            ['nombre' => 'Fútbol Juvenil', 'categoria' => 'Deportivo'],
            ['nombre' => 'Voleibol Recreativo', 'categoria' => 'Deportivo'],
            ['nombre' => 'Pintura y Expresión', 'categoria' => 'Cultural'],
            ['nombre' => 'Cine y Crítica', 'categoria' => 'Cultural'],
        ];

        foreach ($talleres as $taller) {
            Evento::create([
                'nombre'        => $taller['nombre'],
                'descripcion'   => "Descripción de {$taller['nombre']}",
                'categoria'     => $taller['categoria'],

                'cupos'         => rand(10, 50),

                'creado_por'    => $profesores->random()->id_usuario,

                'fecha_inicio'  => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                'fecha_fin'     => Carbon::now()->addDays(rand(31, 90))->format('Y-m-d'),

            ]);
        }

        $this->command->info('Eventos creados exitosamente.');
    }
}
