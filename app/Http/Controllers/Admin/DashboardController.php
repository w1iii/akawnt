<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show admin overview dashboard
     */
    public function index()
    {
        $stats = [
            'total' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'reviewing' => JobApplication::where('status', 'reviewing')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'declined' => JobApplication::where('status', 'declined')->count(),
            'accountants' => User::where('role', 'accountant')->count(),
        ];

        $recentApplications = JobApplication::orderBy('created_at', 'desc')->limit(10)->get();

        // Get online accountants (active in last 5 minutes)
        $onlineAccountants = User::where('role', 'accountant')
            ->where('last_activity_at', '>=', now()->subMinutes(5))
            ->orderBy('last_activity_at', 'desc')
            ->get();

        // Chart data: Applications per day for last 30 days
        $applicationsChartLabels = [];
        $applicationsChartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('M d');
            $count = JobApplication::whereDate('created_at', now()->subDays($i))->count();
            $applicationsChartLabels[] = $date;
            $applicationsChartData[] = $count;
        }

        // Chart data: Applications by status
        $statusChartData = [
            JobApplication::where('status', 'pending')->count(),
            JobApplication::where('status', 'reviewing')->count(),
            JobApplication::where('status', 'accepted')->count(),
            JobApplication::where('status', 'declined')->count(),
        ];

        // Chart data: Accountants activity per day for last 30 days
        $accountantsChartLabels = [];
        $accountantsChartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('M d');
            $count = User::where('role', 'accountant')
                ->whereDate('last_activity_at', now()->subDays($i))
                ->count();
            $accountantsChartLabels[] = $date;
            $accountantsChartData[] = $count;
        }

        $chartData = [
            'applications' => [
                'labels' => $applicationsChartLabels,
                'data' => $applicationsChartData,
            ],
            'accountants' => [
                'labels' => $accountantsChartLabels,
                'data' => $accountantsChartData,
            ],
        ];

        return view('admin.overview', compact('stats', 'recentApplications', 'onlineAccountants', 'chartData'));
    }

    /**
     * Show all job applications
     */
    public function applications(Request $request)
    {
        $query = JobApplication::query();

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by email or name
        if ($request->has('search') && $request->search) {
            $search = '%'.$request->search.'%';
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', $search)
                    ->orWhere('first_name', 'like', $search)
                    ->orWhere('last_name', 'like', $search);
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'reviewing' => JobApplication::where('status', 'reviewing')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'declined' => JobApplication::where('status', 'declined')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'stats'));
    }

    /**
     * Show application details
     */
    public function show(JobApplication $application)
    {
        return view('admin.application-detail', compact('application'));
    }
}
