<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecturer>
 */
class LecturerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->numerify('##########'),
            'name' => fake()->name,
            'gender' => rand(0, 1) == 1 ? 'L' : 'P',
            'phone_number' => '081222778197'
        ];
    }
}
