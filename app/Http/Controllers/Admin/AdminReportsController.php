<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AccountantsExport;
use App\Exports\JobApplicationsExport;
use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AdminReportsController extends Controller
{
    /**
     * Show reports page
     */
    public function index(Request $request)
    {
        $stats = [
            'total_applications' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'reviewing' => JobApplication::where('status', 'reviewing')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'declined' => JobApplication::where('status', 'declined')->count(),
            'total_accountants' => User::where('role', 'accountant')->count(),
            'online_accountants' => User::where('role', 'accountant')
                ->where('last_activity_at', '>=', now()->subMinutes(5))
                ->count(),
        ];

        return view('admin.reports.index', compact('stats'));
    }

    /**
     * Export job applications to Excel
     */
    public function exportApplicationsExcel(Request $request)
    {
        $status = $request->get('status');

        return Excel::download(new JobApplicationsExport($status), 'job-applications-'.date('Y-m-d').'.xlsx');
    }

    /**
     * Export job applications to PDF
     */
    public function exportApplicationsPdf(Request $request)
    {
        $query = JobApplication::query();

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $applications = $query->orderBy('created_at', 'desc')->get();
        $status = $request->status;

        $pdf = Pdf::loadView('admin.reports.applications-pdf', compact('applications', 'status'));

        return $pdf->download('job-applications-'.date('Y-m-d').'.pdf');
    }

    /**
     * Export accountants to Excel
     */
    public function exportAccountantsExcel()
    {
        return Excel::download(new AccountantsExport, 'accountants-'.date('Y-m-d').'.xlsx');
    }

    /**
     * Export accountants to PDF
     */
    public function exportAccountantsPdf()
    {
        $accountants = User::where('role', 'accountant')->orderBy('name')->get();

        $pdf = Pdf::loadView('admin.reports.accountants-pdf', compact('accountants'));

        return $pdf->download('accountants-'.date('Y-m-d').'.pdf');
    }
}
