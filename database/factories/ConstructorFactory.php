<?php

namespace Database\Factories;

use App\Models\Constructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Constructor>
 */
class ConstructorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ref' => fake()->unique()->slug(2),
            'name' => fake()->company(),
            'nationality' => fake()->country(),
        ];
    }
}
