<?php

namespace Database\Seeders;

use App\Models\TaxReport;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaxReportSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'accountant@test.com')->first();

        if (! $user) {
            return;
        }

        $clients = [
            ['name' => 'John Smith', 'email' => 'john@acmecorp.com'],
            ['name' => 'Sarah Johnson', 'email' => 'sarah@techstartup.io'],
            ['name' => 'Michael Brown', 'email' => 'mbrown@globalind.com'],
            ['name' => 'Emily Davis', 'email' => 'emily@smallbiz.com'],
            ['name' => 'Jennifer Martinez', 'email' => 'jennifer@lawfirm.com'],
            ['name' => 'David Lee', 'email' => 'dlee@restaurantgroup.com'],
            ['name' => 'Amanda Taylor', 'email' => 'ataylor@healthcare.com'],
        ];

        $taxTypes = ['Individual', 'Corporate', 'Partnership', 'Estate', 'Quarterly Estimated'];
        $filingStatuses = ['Filed', 'Pending', 'In Progress', 'Extension Filed'];

        $taxReports = [
            [
                'client_name' => 'John Smith',
                'client_email' => 'john@acmecorp.com',
                'tax_type' => 'Corporate',
                'filing_status' => 'Filed',
                'due_date' => now()->subMonths(2),
                'amount' => 12500.00,
                'report_date' => now()->subMonths(2),
            ],
            [
                'client_name' => 'John Smith',
                'client_email' => 'john@acmecorp.com',
                'tax_type' => 'Quarterly Estimated Q1',
                'filing_status' => 'Filed',
                'due_date' => now()->subMonths(4),
                'amount' => 3125.00,
                'report_date' => now()->subMonths(4),
            ],
            [
                'client_name' => 'Sarah Johnson',
                'client_email' => 'sarah@techstartup.io',
                'tax_type' => 'Corporate',
                'filing_status' => 'Pending',
                'due_date' => now()->addMonths(1),
                'amount' => 8500.00,
                'report_date' => now()->subWeek(),
            ],
            [
                'client_name' => 'Michael Brown',
                'client_email' => 'mbrown@globalind.com',
                'tax_type' => 'Corporate',
                'filing_status' => 'Filed',
                'due_date' => now()->subMonths(1),
                'amount' => 45000.00,
                'report_date' => now()->subMonths(1),
            ],
            [
                'client_name' => 'Michael Brown',
                'client_email' => 'mbrown@globalind.com',
                'tax_type' => 'Partnership',
                'filing_status' => 'Filed',
                'due_date' => now()->subMonths(3),
                'amount' => 22000.00,
                'report_date' => now()->subMonths(3),
            ],
            [
                'client_name' => 'Emily Davis',
                'client_email' => 'emily@smallbiz.com',
                'tax_type' => 'Individual',
                'filing_status' => 'Filed',
                'due_date' => now()->subMonths(2),
                'amount' => 4200.00,
                'report_date' => now()->subMonths(2),
            ],
            [
                'client_name' => 'Jennifer Martinez',
                'client_email' => 'jennifer@lawfirm.com',
                'tax_type' => 'Corporate',
                'filing_status' => 'In Progress',
                'due_date' => now()->addWeeks(2),
                'amount' => 18000.00,
                'report_date' => now(),
            ],
            [
                'client_name' => 'David Lee',
                'client_email' => 'dlee@restaurantgroup.com',
                'tax_type' => 'Corporate',
                'filing_status' => 'Filed',
                'due_date' => now()->subMonths(1),
                'amount' => 32000.00,
                'report_date' => now()->subMonths(1),
            ],
            [
                'client_name' => 'David Lee',
                'client_email' => 'dlee@restaurantgroup.com',
                'tax_type' => 'Quarterly Estimated Q1',
                'filing_status' => 'Filed',
                'due_date' => now()->subMonths(4),
                'amount' => 8000.00,
                'report_date' => now()->subMonths(4),
            ],
            [
                'client_name' => 'Amanda Taylor',
                'client_email' => 'ataylor@healthcare.com',
                'tax_type' => 'Individual',
                'filing_status' => 'Extension Filed',
                'due_date' => now()->addMonths(3),
                'amount' => 15000.00,
                'report_date' => now()->subWeek(),
            ],
            [
                'client_name' => 'Amanda Taylor',
                'client_email' => 'ataylor@healthcare.com',
                'tax_type' => 'Corporate',
                'filing_status' => 'Pending',
                'due_date' => now()->addMonths(1),
                'amount' => 25000.00,
                'report_date' => now()->subDays(3),
            ],
        ];

        foreach ($taxReports as $report) {
            TaxReport::create([
                'client_name' => $report['client_name'],
                'client_email' => $report['client_email'],
                'tax_type' => $report['tax_type'],
                'filing_status' => $report['filing_status'],
                'due_date' => $report['due_date'],
                'amount' => $report['amount'],
                'report_date' => $report['report_date'],
                'user_id' => $user->id,
                'client_id' => null,
            ]);
        }
    }
}
