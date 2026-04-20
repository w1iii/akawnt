<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test applicant user (only if not exists)
        if (! User::where('email', 'accountant@test.com')->exists()) {
            User::factory()->create([
                'name' => 'Test Accountant',
                'email' => 'accountant@test.com',
                'password' => bcrypt('password'),
                'role' => 'accountant',
            ]);
        }

        // Create test admin (only if not exists)
        if (! Admin::where('email', 'admin@test.com')->exists()) {
            Admin::factory()->create([
                'name' => 'Test Admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Seed sample data
        $this->call([
            ClientSeeder::class,
            TaxReportSeeder::class,
            AuditReportSeeder::class,
        ]);
    }
}
