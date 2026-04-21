<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use App\Models\AuditReport;
use App\Models\Client;
use App\Models\TaxReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $application = $user->jobApplications()->first();

        $clientsCount = $user->clients()->count();
        $activeClientsCount = $user->clients()->where('status', 'active')->count();
        $taxReportsCount = TaxReport::where('user_id', $user->id)->count();
        $auditReportsCount = AuditReport::where('user_id', $user->id)->count();

        return view('applicant.dashboard', compact(
            'user',
            'application',
            'clientsCount',
            'activeClientsCount',
            'taxReportsCount',
            'auditReportsCount'
        ));
    }

    public function settings()
    {
        $user = Auth::user();
        $application = $user->jobApplications()->first();
        $clientsCount = $user->clients()->count();

        return view('applicant.settings', compact('user', 'application', 'clientsCount'));
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('applicant.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.Auth::id(),
        ]);

        Auth::user()->update($request->only(['name', 'email']));

        return redirect()->route('applicant.dashboard')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('applicant.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('applicant.dashboard')->with('success', 'Password changed successfully!');
    }

    public function clients(Request $request)
    {
        $query = Auth::user()->clients();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('company_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $clients = $query->latest()->paginate(10);

        return view('applicant.clients', compact('clients'));
    }

    public function storeClient(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'services' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $client = Auth::user()->clients()->create($validated);

        $client->activities()->create([
            'type' => 'created',
            'description' => 'Client created',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('applicant.clients')->with('success', 'Client added successfully!');
    }

    public function showClient(Client $client)
    {
        $this->authorizeClient($client);

        return view('applicant.clients-show', compact('client'));
    }

    public function editClient(Client $client)
    {
        $this->authorizeClient($client);

        return view('applicant.clients-edit', compact('client'));
    }

    public function updateClient(Request $request, Client $client)
    {
        $this->authorizeClient($client);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'services' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $client->update($validated);

        $client->activities()->create([
            'type' => 'updated',
            'description' => 'Client details updated',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('applicant.clients.show', $client)->with('success', 'Client updated successfully!');
    }

    public function destroyClient(Client $client)
    {
        $this->authorizeClient($client);

        $client->delete();

        return redirect()->route('applicant.clients')->with('success', 'Client deleted successfully!');
    }

    public function storeActivity(Request $request, Client $client)
    {
        $this->authorizeClient($client);

        $request->validate([
            'type' => 'required|string|max:50',
            'description' => 'required|string',
        ]);

        $client->activities()->create([
            'type' => $request->type,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Activity added successfully!');
    }

    public function reports(Request $request)
    {
        $type = $request->get('type', 'client_summary');
        $dateRange = $request->get('date_range', 'month');

        $startDate = $this->getStartDate($dateRange);
        $endDate = now();

        $data = $this->generateReport($type, $startDate, $endDate);

        return view('applicant.reports', compact('type', 'dateRange', 'data'));
    }

    private function getStartDate(string $range): Carbon
    {
        return match ($range) {
            'today' => now()->startOfDay(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            'custom' => now()->startOfMonth(),
            default => now()->startOfMonth(),
        };
    }

    private function generateReport(string $type, $startDate, $endDate)
    {
        $userId = Auth::id();

        return match ($type) {
            'client_summary' => $this->generateClientSummary($userId, $startDate, $endDate),
            'tax_report' => $this->generateTaxReport($userId, $startDate, $endDate),
            'audit_report' => $this->generateAuditReport($userId, $startDate, $endDate),
            default => [],
        };
    }

    private function generateClientSummary($userId, $startDate, $endDate)
    {
        $clients = Client::where('user_id', $userId)
            ->withCount('activities')
            ->orderByDesc('activities_count')
            ->get();

        return $clients->map(function ($client) {
            $lastActivity = $client->activities()->latest()->first();

            return [
                'client_name' => $client->name,
                'email' => $client->email,
                'company' => $client->company_name,
                'services' => $client->services,
                'status' => $client->status,
                'total_activities' => $client->activities_count,
                'last_activity' => $lastActivity ? $lastActivity->created_at->format('M d, Y') : 'N/A',
            ];
        });
    }

    private function generateTaxReport($userId, $startDate, $endDate)
    {
        return TaxReport::where('user_id', $userId)
            ->whereBetween('report_date', [$startDate, $endDate])
            ->orderByDesc('report_date')
            ->get()
            ->map(function ($report) {
                return [
                    'client_name' => $report->client_name,
                    'client_email' => $report->client_email,
                    'tax_type' => $report->tax_type,
                    'filing_status' => $report->filing_status,
                    'due_date' => $report->due_date->format('M d, Y'),
                    'amount' => $report->amount,
                    'report_date' => $report->report_date->format('M d, Y'),
                ];
            });
    }

    private function generateAuditReport($userId, $startDate, $endDate)
    {
        return AuditReport::where('user_id', $userId)
            ->whereBetween('start_date', [$startDate, $endDate])
            ->orderByDesc('start_date')
            ->get()
            ->map(function ($report) {
                return [
                    'client_name' => $report->client_name,
                    'client_email' => $report->client_email,
                    'audit_type' => $report->audit_type,
                    'start_date' => $report->start_date->format('M d, Y'),
                    'end_date' => $report->end_date ? $report->end_date->format('M d, Y') : 'Ongoing',
                    'status' => $report->status,
                ];
            });
    }

    public function downloadReport(Request $request)
    {
        $type = $request->get('type', 'client_summary');
        $dateRange = $request->get('date_range', 'month');

        $startDate = $this->getStartDate($dateRange);
        $endDate = now();

        $data = $this->generateReport($type, $startDate, $endDate);

        $reportName = match ($type) {
            'client_summary' => 'Client Summary Report',
            'tax_report' => 'Tax Report',
            'audit_report' => 'Audit Report',
            default => 'Report',
        };

        $html = $this->generatePdfHtml($type, $data, $reportName, $dateRange);

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="'.strtolower(str_replace(' ', '_', $reportName)).'_'.now()->format('Y-m-d').'.html"');
    }

    private function generatePdfHtml($type, $data, $reportName, $dateRange)
    {
        $dateRangeLabel = match ($dateRange) {
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
            default => 'This Month',
        };

        $html = '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>'.$reportName.'</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { color: #333; }
        h2 { color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4a5568; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #48bb78; color: white; }
        .badge-warning { background-color: #ed8936; color: white; }
        .badge-secondary { background-color: #718096; color: white; }
        .badge-info { background-color: #4299e1; color: white; }
        .header { margin-bottom: 30px; }
        .meta { color: #718096; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>'.$reportName.'</h1>
        <div class="meta">Generated on '.now()->format('M d, Y h:i A').' | Period: '.$dateRangeLabel.'</div>
    </div>';

        if ($type === 'client_summary') {
            $html .= '
    <table>
        <thead>
            <tr>
                <th>Client Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>Services</th>
                <th>Status</th>
                <th>Activities</th>
                <th>Last Activity</th>
            </tr>
        </thead>
        <tbody>';
            foreach ($data as $client) {
                $statusBadge = $client['status'] === 'active'
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-secondary">Inactive</span>';
                $services = $client['services'] ? implode(', ', $client['services']) : '-';
                $html .= '
            <tr>
                <td>'.$client['client_name'].'</td>
                <td>'.$client['email'].'</td>
                <td>'.($client['company'] ?: '-').'</td>
                <td>'.$services.'</td>
                <td>'.$statusBadge.'</td>
                <td>'.$client['total_activities'].'</td>
                <td>'.$client['last_activity'].'</td>
            </tr>';
            }
            $html .= '
        </tbody>
    </table>';
        } elseif ($type === 'tax_report') {
            $html .= '
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Email</th>
                <th>Tax Type</th>
                <th>Filing Status</th>
                <th>Due Date</th>
                <th>Amount</th>
                <th>Report Date</th>
            </tr>
        </thead>
        <tbody>';
            foreach ($data as $report) {
                $statusBadge = $report['filing_status'] === 'Filed'
                    ? '<span class="badge badge-success">Filed</span>'
                    : '<span class="badge badge-warning">Pending</span>';
                $amount = $report['amount'] ? '$'.number_format($report['amount'], 2) : '-';
                $html .= '
            <tr>
                <td>'.$report['client_name'].'</td>
                <td>'.$report['client_email'].'</td>
                <td>'.$report['tax_type'].'</td>
                <td>'.$statusBadge.'</td>
                <td>'.$report['due_date'].'</td>
                <td>'.$amount.'</td>
                <td>'.$report['report_date'].'</td>
            </tr>';
            }
            $html .= '
        </tbody>
    </table>';
        } elseif ($type === 'audit_report') {
            $html .= '
    <table>
        <thead>
            <tr>
                <th>Client</th>
                <th>Email</th>
                <th>Audit Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>';
            foreach ($data as $report) {
                $statusBadge = match ($report['status']) {
                    'completed' => '<span class="badge badge-success">Completed</span>',
                    'in_progress' => '<span class="badge badge-info">In Progress</span>',
                    default => '<span class="badge badge-warning">Pending</span>',
                };
                $html .= '
            <tr>
                <td>'.$report['client_name'].'</td>
                <td>'.$report['client_email'].'</td>
                <td>'.$report['audit_type'].'</td>
                <td>'.$report['start_date'].'</td>
                <td>'.$report['end_date'].'</td>
                <td>'.$statusBadge.'</td>
            </tr>';
            }
            $html .= '
        </tbody>
    </table>';
        }

        $html .= '
</body>
</html>';

        return $html;
    }

    private function authorizeClient(Client $client)
    {
        if ($client->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
