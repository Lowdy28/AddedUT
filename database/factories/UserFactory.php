<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'), // contraseña por defecto
            'role' => 'estudiante', // por defecto todos los generados son estudiantes
            'remember_token' => \Str::random(10),
        ];
    }

    /**
     * Estado para profesor
     */
    public function profesor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'profesor',
        ]);
    }

    /**
     * Estado para admin
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }
}
