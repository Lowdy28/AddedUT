<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        Usuario::create([
            'nombre' => 'Administrador UTT',
            'email' => 'admin@utt.edu.mx',
            'password' => Hash::make('Admin123*'),
            'rol' => 'admin',
            'activo' => 1,
            'fecha_registro' => now(),
        ]);

        // Profesores
        Usuario::factory()->count(10)->profesor()->create();

        // Estudiantes
        Usuario::factory()->count(150)->create();
    }
}
