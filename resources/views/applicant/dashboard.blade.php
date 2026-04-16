@extends('layouts.dashboard')

@section('title', 'Applicant Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome, {{ Auth::user()->name }}</h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Your Profile</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Email</h6>
                        <p>{{ Auth::user()->email }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Full Name</h6>
                        <p>{{ Auth::user()->name }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="text-muted">Member Since</h6>
                        <p>{{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('applicant.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                        <a href="{{ route('applicant.password.change') }}" class="btn btn-outline-primary">Change Password</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($application)
                <div class="card mt-3">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Your Application</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Position:</strong> {{ $application->position }}</p>
                        <p>
                            <strong>Status:</strong>
                            @if($application->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($application->status === 'reviewing')
                                <span class="badge bg-info">Reviewing</span>
                            @elseif($application->status === 'accepted')
                                <span class="badge bg-success">Accepted</span>
                            @else
                                <span class="badge bg-danger">Declined</span>
                            @endif
                        </p>
                        <p><small class="text-muted">Applied on {{ $application->created_at->format('M d, Y') }}</small></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
