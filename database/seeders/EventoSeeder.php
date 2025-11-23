<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\Usuario;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $profesores = Usuario::where('rol', 'profesor')->get();

        if ($profesores->isEmpty()) {
            $this->command->info('No hay profesores para asignar eventos. Seeder omitido.');
            return;
        }

        foreach (range(1, 20) as $i) {
            Evento::create([
                'nombre' => "Evento $i",
                'descripcion' => "Descripción del evento $i",
                'categoria' => ['General','Académico','Cultural','Deportivo'][array_rand(['General','Académico','Cultural','Deportivo'])],
                'cupos' => rand(10,50),
                'creado_por' => $profesores->random()->id_usuario,
            ]);
        }

        $this->command->info('Eventos creados exitosamente.');
    }
}
