<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inscripcion;
use App\Models\Usuario;
use App\Models\Evento;

class InscripcionSeeder extends Seeder
{
    public function run(): void
    {
        $estudiantes = Usuario::where('rol', 'estudiante')->get();
        $eventos = Evento::all();

        if ($eventos->isEmpty()) return;

        foreach ($estudiantes as $estudiante) {
            Inscripcion::create([
                'id_usuario' => $estudiante->id_usuario,
                'id_evento' => $eventos->random()->id_evento,
                'estado' => 'confirmada',
            ]);
        }
    }
}
