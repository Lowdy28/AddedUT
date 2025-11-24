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
            ['nombre_evento' => 'Música para todos', 'categoria' => 'Cultural'],
            ['nombre_evento' => 'Taller de Teatro', 'categoria' => 'Cultural'],
            ['nombre_evento' => 'Clases de Dibujo', 'categoria' => 'Cultural'],
            ['nombre_evento' => 'Baile Contemporáneo', 'categoria' => 'Cultural'],
            ['nombre_evento' => 'Fotografía Creativa', 'categoria' => 'Cultural'],
            ['nombre_evento' => 'Coro Comunitario', 'categoria' => 'Cultural'],
            ['nombre_evento' => 'Yoga y Bienestar', 'categoria' => 'Deportivo'],
            ['nombre_evento' => 'Taekwondo Infantil', 'categoria' => 'Deportivo'],
            ['nombre_evento' => 'Fútbol Juvenil', 'categoria' => 'Deportivo'],
            ['nombre_evento' => 'Voleibol Recreativo', 'categoria' => 'Deportivo'],
            ['nombre_evento' => 'Pintura y Expresión', 'categoria' => 'Cultural'],
            ['nombre_evento' => 'Cine y Crítica', 'categoria' => 'Cultural'],
        ];

        foreach ($talleres as $taller) {
            Evento::create([
                'nombre_evento' => $taller['nombre_evento'],
                'descripcion' => "Descripción de {$taller['nombre_evento']}",
                'categoria' => $taller['categoria'],
                'cupo_maximo' => rand(10, 50),
                'cupo_disponible' => rand(10, 50),
                'creado_por' => $profesores->random()->id_usuario,
                'fecha_inicio' => Carbon::now()->addDays(rand(1, 90))->format('Y-m-d'),
                'fecha_fin' => Carbon::now()->addDays(rand(91, 180))->format('Y-m-d'),
                'fecha_creacion' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

        $this->command->info('Eventos creados exitosamente.');
    }
}
