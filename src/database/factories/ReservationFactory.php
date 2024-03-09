<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 2, $max = 11),
            'shop_id' => $this->faker->numberBetween($min = 1, $max = 20),
            'date' => $this->faker->dateTimeBetween('+1 day', '+1 year'),
            'time' => $this->faker->time($format = 'H:i'),
            'number' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 'over_10']),
        ];
    }
}
