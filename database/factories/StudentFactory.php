<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->numerify('#########'),
            'name' => fake()->name,
            'place_of_birth' => fake()->city,
            'date_of_birth' => fake()->date,
            'address' => fake()->address,
            'gender' => rand(0, 1) == 1 ? 'L' : 'P',
            'stamp' => rand(2020, 2023),
            'phone_number' => '081222778197'
        ];
    }
}
