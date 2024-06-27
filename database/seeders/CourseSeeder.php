<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Curriculum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Curriculum::all() as $curriculum)
            Course::factory()
                ->count(rand(10, 30))
                ->for($curriculum)
                ->create();
    }
}
