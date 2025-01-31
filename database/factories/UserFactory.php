<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => 'cliente',               
            'remember_token' => Str::random(10),
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function gestore(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'gestore',
        ]);
    }

    public function cliente(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'cliente',
        ]);
    }
}
