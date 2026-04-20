<?php

namespace Database\Seeders;

use App\Models\AuditReport;
use App\Models\User;
use Illuminate\Database\Seeder;

class AuditReportSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'accountant@test.com')->first();

        if (! $user) {
            return;
        }

        $auditReports = [
            [
                'client_name' => 'John Smith',
                'client_email' => 'john@acmecorp.com',
                'audit_type' => 'Financial Audit',
                'start_date' => now()->subMonths(3),
                'end_date' => now()->subMonths(2),
                'status' => 'completed',
                'findings' => 'No material issues found. All financial statements are accurate.',
            ],
            [
                'client_name' => 'Sarah Johnson',
                'client_email' => 'sarah@techstartup.io',
                'audit_type' => 'Compliance Audit',
                'start_date' => now()->subMonth(),
                'end_date' => null,
                'status' => 'in_progress',
                'findings' => 'Audit in progress. Preliminary review shows minor discrepancies.',
            ],
            [
                'client_name' => 'Michael Brown',
                'client_email' => 'mbrown@globalind.com',
                'audit_type' => 'Internal Audit',
                'start_date' => now()->subMonths(2),
                'end_date' => now()->subWeeks(2),
                'status' => 'completed',
                'findings' => 'Several internal controls need improvement. Recommendations provided.',
            ],
            [
                'client_name' => 'Jennifer Martinez',
                'client_email' => 'jennifer@lawfirm.com',
                'audit_type' => 'Financial Audit',
                'start_date' => now()->subWeeks(3),
                'end_date' => null,
                'status' => 'in_progress',
                'findings' => 'On-site audit ongoing. Reviewing financial records and internal controls.',
            ],
            [
                'client_name' => 'David Lee',
                'client_email' => 'dlee@restaurantgroup.com',
                'audit_type' => 'Tax Audit',
                'start_date' => now()->subMonths(4),
                'end_date' => now()->subMonths(3),
                'status' => 'completed',
                'findings' => 'Tax compliance verified. All filings accurate.',
            ],
            [
                'client_name' => 'Amanda Taylor',
                'client_email' => 'ataylor@healthcare.com',
                'audit_type' => 'Compliance Audit',
                'start_date' => now()->addWeeks(2),
                'end_date' => null,
                'status' => 'pending',
                'findings' => null,
            ],
            [
                'client_name' => 'Emily Davis',
                'client_email' => 'emily@smallbiz.com',
                'audit_type' => 'Review Engagement',
                'start_date' => now()->subMonths(5),
                'end_date' => now()->subMonths(4),
                'status' => 'completed',
                'findings' => 'Review completed. Financial position appears sound.',
            ],
        ];

        foreach ($auditReports as $report) {
            AuditReport::create([
                'client_name' => $report['client_name'],
                'client_email' => $report['client_email'],
                'audit_type' => $report['audit_type'],
                'start_date' => $report['start_date'],
                'end_date' => $report['end_date'],
                'status' => $report['status'],
                'findings' => $report['findings'],
                'user_id' => $user->id,
                'client_id' => null,
            ]);
        }
    }
}
