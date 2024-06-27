<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => Str::upper(fake()->bothify('??####')),
            'name' => Str::headline(join(' ', fake()->words(rand(2, 4)))),
            'description' => fake()->sentence,
            'semester' => rand(1, 8),
            'credit' => rand(1, 6)
        ];
    }
}
