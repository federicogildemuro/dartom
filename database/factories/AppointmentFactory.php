<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Barber;
use App\Models\User;

class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        $hours = ['10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30'];

        return [
            'barber_id' => Barber::inRandomOrder()->first()->id,
            'user_id' => $this->faker->randomElement([null, User::where('id', '!=', 1)->inRandomOrder()->first()->id]),
            'date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'time' => $this->faker->randomElement($hours),
        ];
    }
}
