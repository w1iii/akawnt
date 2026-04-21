<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientActivity;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'accountant@test.com')->first();

        if (! $user) {
            $user = User::factory()->create([
                'name' => 'Test Accountant',
                'email' => 'accountant@test.com',
                'password' => bcrypt('password'),
                'role' => 'accountant',
            ]);
        }

        $clients = [
            [
                'name' => 'John Smith',
                'email' => 'john@acmecorp.com',
                'phone' => '555-123-4567',
                'company_name' => 'ACME Corporation',
                'address' => '123 Main St, New York, NY 10001',
                'status' => 'active',
                'services' => ['Tax Preparation', 'Bookkeeping'],
                'notes' => 'Long-term client since 2020. Prefers email communication.',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@techstartup.io',
                'phone' => '555-234-5678',
                'company_name' => 'Tech Startup Inc',
                'address' => '456 Tech Blvd, San Francisco, CA 94105',
                'status' => 'active',
                'services' => ['Payroll', 'Financial Planning'],
                'notes' => 'Fast-growing startup, needs quarterly reviews.',
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'mbrown@globalind.com',
                'phone' => '555-345-6789',
                'company_name' => 'Global Industries',
                'address' => '789 Industrial Way, Chicago, IL 60601',
                'status' => 'active',
                'services' => ['Audit', 'Tax Preparation'],
                'notes' => 'Large client with multiple subsidiaries.',
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@smallbiz.com',
                'phone' => '555-456-7890',
                'company_name' => 'Davis Consulting',
                'address' => '321 Oak Ave, Boston, MA 02101',
                'status' => 'active',
                'services' => ['Bookkeeping', 'Payroll'],
                'notes' => 'Small business owner, new client this year.',
            ],
            [
                'name' => 'Robert Wilson',
                'email' => 'rwilson@retired.com',
                'phone' => '555-567-8901',
                'company_name' => null,
                'address' => '555 Pine St, Seattle, WA 98101',
                'status' => 'inactive',
                'services' => ['Tax Preparation'],
                'notes' => 'Retired, only needs annual tax filing.',
            ],
            [
                'name' => 'Jennifer Martinez',
                'email' => 'jennifer@lawfirm.com',
                'phone' => '555-678-9012',
                'company_name' => 'Martinez & Associates Law Firm',
                'address' => '777 Legal Plaza, Miami, FL 33101',
                'status' => 'active',
                'services' => ['Bookkeeping', 'Audit'],
                'notes' => 'Law firm with 15 employees.',
            ],
            [
                'name' => 'David Lee',
                'email' => 'dlee@restaurantgroup.com',
                'phone' => '555-789-0123',
                'company_name' => 'Lee Restaurant Group',
                'address' => '888 Food Court, Los Angeles, CA 90001',
                'status' => 'active',
                'services' => ['Tax Preparation', 'Payroll', 'Bookkeeping'],
                'notes' => 'Multiple restaurant locations, complex payroll.',
            ],
            [
                'name' => 'Amanda Taylor',
                'email' => 'ataylor@healthcare.com',
                'phone' => '555-890-1234',
                'company_name' => 'Taylor Healthcare',
                'address' => '999 Medical Dr, Dallas, TX 75201',
                'status' => 'active',
                'services' => ['Financial Planning', 'Audit'],
                'notes' => 'Medical practice with 3 locations.',
            ],
        ];

        foreach ($clients as $clientData) {
            $client = Client::create([
                'name' => $clientData['name'],
                'email' => $clientData['email'],
                'phone' => $clientData['phone'],
                'company_name' => $clientData['company_name'],
                'address' => $clientData['address'],
                'status' => $clientData['status'],
                'services' => $clientData['services'],
                'notes' => $clientData['notes'],
                'user_id' => $user->id,
            ]);

            $activities = [
                ['type' => 'created', 'description' => 'Client account created'],
                ['type' => 'contact', 'description' => 'Initial consultation completed'],
                ['type' => 'service', 'description' => 'Services configured: '.implode(', ', $clientData['services'])],
            ];

            if ($clientData['status'] === 'inactive') {
                $activities[] = ['type' => 'note', 'description' => 'Client marked as inactive'];
            }

            foreach ($activities as $activity) {
                ClientActivity::create([
                    'type' => $activity['type'],
                    'description' => $activity['description'],
                    'client_id' => $client->id,
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
