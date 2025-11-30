<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name' => 'yuzu',
                'email' => 'yuzu@gmail.com',
                'role' => 'admin',
                'password' => bcrypt('admin123')
            ],
            [
                'name' => 'Yuri',
                'email' => 'yuri@gmail.com',
                'role' => 'instructor',
                'password' => bcrypt('hydrangea1123')
            ],
            [
                'name' => 'Mizuki',
                'email' => 'mizuki@gmail.com',
                'role' => 'student',
                'password' => bcrypt('yuridaisuki1123')
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
