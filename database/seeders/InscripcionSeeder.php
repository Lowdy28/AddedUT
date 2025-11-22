<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscripcion;
use App\Models\User;
use App\Models\Evento;

class InscripcionSeeder extends Seeder
{
    public function run(): void
    {
        $estudiantes = User::where('role', 'estudiante')->get();
        $eventos = Evento::all();

        if ($eventos->isEmpty()) return;

        foreach ($estudiantes as $estudiante) {
            Inscripcion::create([
                'user_id' => $estudiante->id,
                'evento_id' => $eventos->random()->id,
                'estado' => 'confirmada',
            ]);
        }
    }
}
