<?php

namespace App\Http\Controllers;

use App\Mail\ApplicationAccepted;
use App\Mail\ApplicationDeclined;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    /**
     * Store a new job application
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'position' => 'required|string|max:255',
            'message' => 'required|string',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $emailExist = JobApplication::where('email', $validated['email'])->exists();
        if ($emailExist) {
            return redirect()->back()
                ->with('error', 'This email address is already registered.')
                ->with('scroll_to', 'contact')
                ->withInput();
        }

        $phoneExist = JobApplication::where('phone', $validated['phone'])->exists();
        if ($phoneExist) {
            return redirect()->back()
                ->with('error', 'This phone number is already registered.')
                ->with('scroll_to', 'contact')
                ->withInput();
        }

        $resumePath = null;
        if ($request->hasFile('resume')) {
            $resumePath = $request->file('resume')->store('resumes', 'private');
        }

        JobApplication::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'position' => $validated['position'],
            'message' => $validated['message'],
            'resume_path' => $resumePath,
        ]);

        return redirect()->back()
            ->with('success', 'Your application has been submitted successfully!')
            ->with('scroll_to', 'contact');
    }

    /**
     * Accept a job application and create user account
     */
    public function accept(JobApplication $application)
    {
        // Can only accept if not already accepted or declined
        if ($application->status === 'accepted' || $application->status === 'declined') {
            return redirect()->back()->with('error', 'This application cannot be accepted.');
        }

        // Generate temporary password
        $tempPassword = Str::random(12);

        // Create user account
        $user = User::create([
            'name' => $application->first_name.' '.$application->last_name,
            'email' => $application->email,
            'password' => Hash::make($tempPassword),
            'role' => 'accountant',
        ]);

        // Update application
        $application->update([
            'status' => 'accepted',
            'user_id' => $user->id,
        ]);

        // Send acceptance email
        Mail::to($application->email)->send(new ApplicationAccepted($application, $tempPassword));

        return redirect()->back()->with('success', 'Application accepted! Acceptance email sent.');
    }

    /**
     * Decline a job application
     */
    public function decline(JobApplication $application)
    {
        // Can only decline if not already accepted or declined
        if ($application->status === 'accepted' || $application->status === 'declined') {
            return redirect()->back()->with('error', 'This application cannot be declined.');
        }

        $application->update(['status' => 'declined']);

        // Send decline email
        Mail::to($application->email)->send(new ApplicationDeclined($application));

        return redirect()->back()->with('success', 'Application declined! Notification email sent.');
    }

    /**
     * Mark application as reviewing
     */
    public function review(JobApplication $application)
    {
        if ($application->status !== 'pending') {
            return redirect()->back()->with('error', 'This application cannot be marked as reviewing.');
        }

        $application->update(['status' => 'reviewing']);

        return redirect()->back()->with('success', 'Application marked as reviewing.');
    }

    /**
     * Download resume file
     */
    public function downloadResume(JobApplication $application)
    {
        if (! $application->resume_path) {
            return redirect()->back()->with('error', 'Resume not found.');
        }

        return Storage::disk('private')->download($application->resume_path, $application->first_name.'_'.$application->last_name.'_resume.pdf');
    }
}
