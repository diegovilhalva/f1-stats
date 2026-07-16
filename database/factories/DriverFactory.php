<?php

namespace Database\Factories;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ref' => fake()->unique()->userName(),
            'code' => strtoupper(fake()->lexify('???')),
            'number' => fake()->numberBetween(1, 99),
            'forename' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'nationality' => fake()->country(),
            'dob' => fake()->date(),
        ];
    }
}
