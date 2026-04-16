<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test applicant user
        \App\Models\User::factory()->create([
            'name' => 'Test Accountant',
            'email' => 'accountant@test.com',
            'password' => bcrypt('password'),
            'role' => 'accountant',
        ]);

        // Create test admin
        \App\Models\Admin::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ]);
    }
}
