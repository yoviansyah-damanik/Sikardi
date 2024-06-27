<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\UserType;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create(
            [
                'password' => bcrypt('password'),
                'email' => 'situhir@example.com'
            ]
        );

        $staff = Staff::create([
            'id' => '1234567890',
            'name' => 'Administrator',
            'phone_number' => '081222778197'
        ]);

        $userType = new UserType(['user_id' => $user->id]);

        $staff->userable()->save($userType);
    }
}
