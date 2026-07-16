<?php

namespace Database\Factories;

use App\Models\Result;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Result>
 */
class ResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'race_id' => \App\Models\Race::factory(),
            'driver_id' => \App\Models\Driver::factory(),
            'constructor_id' => \App\Models\Constructor::factory(),
            'grid' => fake()->numberBetween(1, 20),
            'position' => fake()->numberBetween(1, 20),
            'points' => fake()->randomElement([25, 18, 15, 12, 10, 8, 6, 4, 2, 1, 0]),
            'status' => 'Finished',
            'fastest_lap_time' => null,
        ];
    }
}
