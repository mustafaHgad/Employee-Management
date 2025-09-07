<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            DepartmentSeeder::class,
        ]);

        $this->call([
            EmployeeSeeder::class,
        ]);

        // Create a test user for auth
        User::factory()->createMany([
            [
                'name' => 'employee',
                'email' => 'employee@example.com',
                'password' => bcrypt('password'),
                'role' => 'employee',
            ],
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
            ]
        ]);
    }
}
