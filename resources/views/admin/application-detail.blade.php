@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Application</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Application Details</h2>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="button button-secondary">
            <span class="material-symbols-outlined">arrow_back</span>
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">description</span>
                    <h3 class="text-lg font-bold text-on-surface">Application Details</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">First Name</p>
                        <p class="font-bold text-on-surface">{{ $application->first_name }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Last Name</p>
                        <p class="font-bold text-on-surface">{{ $application->last_name }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Email</p>
                        <p class="font-bold text-on-surface">{{ $application->email }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Phone</p>
                        <p class="font-bold text-on-surface">{{ $application->phone }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Position</p>
                        <p class="font-bold text-on-surface">{{ $application->position }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Applied Date</p>
                        <p class="font-bold text-on-surface">{{ $application->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">mail</span>
                    <h3 class="text-lg font-bold text-on-surface">Cover Letter</h3>
                </div>
                <p class="text-on-surface-variant whitespace-pre-wrap">{{ $application->message }}</p>
            </div>

            @if($application->resume_path)
            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary">attach_file</span>
                    <h3 class="text-lg font-bold text-on-surface">Resume</h3>
                </div>
                <a href="{{ route('admin.application.download-resume', $application) }}" class="button button-primary" target="_blank">
                    <span class="material-symbols-outlined">download</span>
                    Download Resume
                </a>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">fact_check</span>
                    <h3 class="text-lg font-bold text-on-surface">Status</h3>
                </div>
                
                <div class="mb-6">
                    <p class="text-xs text-on-surface-variant mb-2">Current Status</p>
                    @if($application->status === 'pending')
                        <span class="inline-flex items-center gap-1 text-sm font-bold text-yellow-600 bg-yellow-50 px-3 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-yellow-600"></span> Pending
                        </span>
                    @elseif($application->status === 'reviewing')
                        <span class="inline-flex items-center gap-1 text-sm font-bold text-blue-600 bg-blue-50 px-3 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-blue-600"></span> Reviewing
                        </span>
                    @elseif($application->status === 'accepted')
                        <span class="inline-flex items-center gap-1 text-sm font-bold text-green-600 bg-green-50 px-3 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-green-600"></span> Accepted
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-sm font-bold text-red-600 bg-red-50 px-3 py-1.5 rounded-full">
                            <span class="w-2 h-2 rounded-full bg-red-600"></span> Declined
                        </span>
                    @endif
                </div>

                @if($application->user)
                <div class="bg-blue-50 p-4 rounded-lg mb-6">
                    <p class="text-xs text-blue-600 font-bold mb-2">Account Created</p>
                    <p class="text-sm text-on-surface">Email: {{ $application->user->email }}</p>
                    <p class="text-sm text-on-surface">Name: {{ $application->user->name }}</p>
                </div>
                @endif

                <div class="space-y-3">
                    @if($application->status === 'pending')
                        <form action="{{ route('admin.application.review', $application) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="button button-warning w-full">
                                <span class="material-symbols-outlined">search</span>
                                Mark as Reviewing
                            </button>
                        </form>
                    @endif

                    @if($application->status !== 'accepted' && $application->status !== 'declined')
                        <form action="{{ route('admin.application.accept', $application) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="button button-success w-full" onclick="return confirm('Accept this application and create user account?');">
                                <span class="material-symbols-outlined">check_circle</span>
                                Accept & Create Account
                            </button>
                        </form>
                        <form action="{{ route('admin.application.decline', $application) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="button button-danger w-full" onclick="return confirm('Decline this application?');">
                                <span class="material-symbols-outlined">cancel</span>
                                Decline
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection