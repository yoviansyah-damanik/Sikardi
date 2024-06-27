<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(StaffSeeder::class);
        $this->call(LecturerSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(ConfigurationSeeder::class);
        $this->call(RoomSeeder::class);
        $this->call(CurriculumSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(LectureSeeder::class);
        $this->call(SupervisorSeeder::class);
        // User::factory(10)->create();

    }
}
