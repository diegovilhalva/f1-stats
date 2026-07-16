<?php

namespace Database\Factories;

use App\Models\Standing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Standing>
 */
class StandingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'season_id' => \App\Models\Season::factory(),
            'driver_id' => null,
            'constructor_id' => \App\Models\Constructor::factory(),
            'type' => 'driver',
            'points' => fake()->numberBetween(0, 400),
            'position' => fake()->numberBetween(1, 20),
            'wins' => fake()->numberBetween(0, 10),
        ];
    }
}
