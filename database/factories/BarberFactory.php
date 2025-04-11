<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BarberFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'photo' => null,
        ];
    }
}
