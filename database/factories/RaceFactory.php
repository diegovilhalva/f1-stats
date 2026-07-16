<?php

namespace Database\Factories;

use App\Models\Race;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Race>
 */
class RaceFactory extends Factory
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
            'circuit_id' => \App\Models\Circuit::factory(),
            'round' => fake()->numberBetween(1, 24),
            'name' => fake()->city() . ' Grand Prix',
            'date' => fake()->date(),
            'time' => fake()->time(),
        ];
    }
}
