<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'passwordHash' => Hash::make('password'),
            'role' => $this->faker->randomElement(['Admin', 'User']),
            'admin' => $this->faker->boolean,
            'createdAt' => now(),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Admin',
            'admin' => true,
        ];
    }

    public function regular(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'User',
            'admin' => false,
        ]);
    }
}