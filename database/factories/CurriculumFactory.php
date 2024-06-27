<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curriculum>
 */
class CurriculumFactory extends Factory
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
            'year' => rand(2010, 2024),
            'description' => fake()->sentence
        ];
    }
}
