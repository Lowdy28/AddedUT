<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evento;
use App\Models\User;

class EventoSeeder extends Seeder
{
    public function run(): void
    {
        $profesores = User::where('role', 'profesor')->get();

        if ($profesores->isEmpty()) return;

        foreach (range(1, 20) as $i) {
            Evento::create([
                'nombre' => "Evento $i",
                'descripcion' => "Descripción del evento $i",
                'categoria' => 'General',
                'cupos' => rand(10, 50),
                'creado_por' => $profesores->random()->id,
            ]);
        }
    }
}
