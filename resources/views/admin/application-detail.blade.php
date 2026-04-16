@extends('layouts.admin')

@section('title', 'Application Details')

@section('content')
<div class="container mt-5">
    <div class="mb-5">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Application Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">First Name</h6>
                            <p>{{ $application->first_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Last Name</h6>
                            <p>{{ $application->last_name }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Email</h6>
                            <p><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Phone</h6>
                            <p><a href="tel:{{ $application->phone }}">{{ $application->phone }}</a></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-muted">Position Applied For</h6>
                            <p>{{ $application->position }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Applied Date</h6>
                            <p>{{ $application->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <h6 class="text-muted">Cover Letter / Message</h6>
                        <p>{{ $application->message }}</p>
                    </div>

                    @if($application->resume_path)
                        <div class="mb-3">
                            <h6 class="text-muted">Resume</h6>
                            <p>
                                <a href="{{ route('admin.application.download-resume', $application) }}" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="bi bi-download"></i> Download Resume
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Status</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Current Status</h6>
                        @if($application->status === 'pending')
                            <span class="badge bg-warning p-2">Pending</span>
                        @elseif($application->status === 'reviewing')
                            <span class="badge bg-info p-2">Reviewing</span>
                        @elseif($application->status === 'accepted')
                            <span class="badge bg-success p-2">Accepted</span>
                        @else
                            <span class="badge bg-danger p-2">Declined</span>
                        @endif
                    </div>

                    @if($application->user)
                        <div class="alert alert-info">
                            <strong>Account Created:</strong><br>
                            Email: {{ $application->user->email }}<br>
                            Name: {{ $application->user->name }}
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        @if($application->status === 'pending')
                            <form action="{{ route('admin.application.review', $application) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">Mark as Reviewing</button>
                            </form>
                        @endif

                        @if($application->status !== 'accepted' && $application->status !== 'declined')
                            <form action="{{ route('admin.application.accept', $application) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Accept this application and create user account?');">
                                    <i class="bi bi-check-circle"></i> Accept & Create Account
                                </button>
                            </form>
                            <form action="{{ route('admin.application.decline', $application) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Decline this application?');">
                                    <i class="bi bi-x-circle"></i> Decline
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
