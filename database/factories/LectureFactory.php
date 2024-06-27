<?php

namespace Database\Factories;

use App\Enums\DayChoice;
use App\Models\Course;
use App\Models\Lecturer;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lecture>
 */
class LectureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'course_id' => Course::inRandomOrder()->first()->id,
            'room_id' => Room::inRandomOrder()->first()->id,
            'lecturer_id' => Lecturer::inRandomOrder()->first()->id,
            'day' => DayChoice::names()[rand(0, 5)],
            'start_time' => fake()->time('H:i'),
            'end_time' => fake()->time('H:i'),
            'limit' => 40
        ];
    }
}
