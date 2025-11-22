<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador UTT',
            'email' => 'admin@utt.edu.mx',
            'password' => Hash::make('Admin123*'),
        ]);

        User::factory()->count(10)->create([
            'role' => 'profesor',
        ]);

        User::factory()->count(150)->create([
            'role' => 'estudiante',
        ]);
    }
}
