<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UsuarioSeeder::class,
            ActividadSeeder::class,
            EventoSeeder::class,
            InscripcionSeeder::class,
        ]);
    }
}
