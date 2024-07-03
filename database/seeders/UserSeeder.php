<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => 'admin1234',
                'role' => 'admin'
            ],
            [
                'name' => 'Area Manager',
                'email' => 'area@gmail.com',
                'password' => 'area1234',
                'role' => 'area-manager'
            ],
            [
                'name' => 'Counter Manager',
                'email' => 'counter@gmail.com',
                'password' => 'counter1234',
                'role' => 'counter-manager'
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => 'user1234',
                'role' => 'user'
            ],
            [
                'name' => 'Driver',
                'email' => 'driver@gmail.com',
                'password' => 'driver1234',
                'role' => 'driver'
            ]
            ];

            foreach ($users as $user) {
               User::create($user);
            }
    }
}
