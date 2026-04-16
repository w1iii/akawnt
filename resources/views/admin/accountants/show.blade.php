@extends('layouts.admin')

@section('title', 'View Accountant')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>{{ $accountant->name }}</h1>
        <div>
            <a href="{{ route('admin.accountants.edit', $accountant) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit Accountant
            </a>
            <a href="{{ route('admin.accountants.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Accountant Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Name:</strong></div>
                    <div class="col-sm-9">{{ $accountant->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Email:</strong></div>
                    <div class="col-sm-9">{{ $accountant->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Role:</strong></div>
                    <div class="col-sm-9">
                        <span class="badge bg-primary">{{ ucfirst($accountant->role) }}</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Member Since:</strong></div>
                    <div class="col-sm-9">{{ $accountant->created_at->format('M d, Y \a\t h:i A') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3"><strong>Last Updated:</strong></div>
                    <div class="col-sm-9">{{ $accountant->updated_at->format('M d, Y \a\t h:i A') }}</div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Job Applications</h5>
            </div>
            <div class="card-body">
                @if($accountant->jobApplications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($accountant->jobApplications as $application)
                                    <tr>
                                        <td>{{ $application->position }}</td>
                                        <td>
                                            @if($application->status === 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($application->status === 'reviewing')
                                                <span class="badge bg-info">Reviewing</span>
                                            @elseif($application->status === 'accepted')
                                                <span class="badge bg-success">Accepted</span>
                                            @else
                                                <span class="badge bg-danger">Declined</span>
                                            @endif
                                        </td>
                                        <td>{{ $application->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.application.show', $application) }}" class="btn btn-sm btn-info">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No job applications found for this accountant.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.accountants.edit', $accountant) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i>Edit Accountant
                    </a>
                    <form action="{{ route('admin.accountants.destroy', $accountant) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this accountant? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete Accountant
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection