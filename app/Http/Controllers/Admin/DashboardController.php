<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard with all applications
     */
    public function index(Request $request)
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
            'accountants' => User::where('role', 'accountant')->count(),
        ];

        return view('admin.dashboard', compact('applications', 'stats'));
    }

    /**
     * Show application details
     */
    public function show(JobApplication $application)
    {
        return view('admin.application-detail', compact('application'));
    }
}
