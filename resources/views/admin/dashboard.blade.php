@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Job Applications Dashboard</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <h2 class="text-warning">{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Reviewing</h5>
                    <h2 class="text-info">{{ $stats['reviewing'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Accepted</h5>
                    <h2 class="text-success">{{ $stats['accepted'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Declined</h5>
                    <h2 class="text-danger">{{ $stats['declined'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Management Links -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Accountant Management</h5>
                    <p class="card-text">Manage accountant users and their applications</p>
                    <h3 class="text-primary">{{ $stats['accountants'] }}</h3>
                    <p class="text-muted">Active Accountants</p>
                    <a href="{{ route('admin.accountants.index') }}" class="btn btn-primary">
                        <i class="bi bi-calculator me-2"></i>Manage Accountants
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Admin Management</h5>
                    <p class="card-text">Manage administrator accounts</p>
                    <a href="{{ route('admin.management.index') }}" class="btn btn-secondary">
                        <i class="bi bi-people me-2"></i>Manage Admins
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <small class="text-muted">Total: {{ $stats['total'] }} applications</small>
            </div>
            <form method="GET" class="row g-3">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search by email or name..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" @if(request('status') == 'pending') selected @endif>Pending</option>
                        <option value="reviewing" @if(request('status') == 'reviewing') selected @endif>Reviewing</option>
                        <option value="accepted" @if(request('status') == 'accepted') selected @endif>Accepted</option>
                        <option value="declined" @if(request('status') == 'declined') selected @endif>Declined</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Position</th>
                    <th>Status</th>
                    <th>Applied Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $app)
                    <tr>
                        <td>{{ $app->first_name }} {{ $app->last_name }}</td>
                        <td>{{ $app->email }}</td>
                        <td>{{ $app->phone }}</td>
                        <td>{{ $app->position }}</td>
                        <td>
                            @if($app->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($app->status === 'reviewing')
                                <span class="badge bg-info">Reviewing</span>
                            @elseif($app->status === 'accepted')
                                <span class="badge bg-success">Accepted</span>
                            @else
                                <span class="badge bg-danger">Declined</span>
                            @endif
                        </td>
                        <td>{{ $app->created_at->format('M d, Y') }}</td>
                        <td>
                            <a href="{{ route('admin.application.show', $app) }}" class="btn btn-sm btn-info">View</a>
                            @if($app->status === 'pending')
                                <form action="{{ route('admin.application.review', $app) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning">Review</button>
                                </form>
                            @endif
                            @if($app->status !== 'accepted' && $app->status !== 'declined')
                                <form action="{{ route('admin.application.accept', $app) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Accept this application?');">Accept</button>
                                </form>
                                <form action="{{ route('admin.application.decline', $app) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Decline this application?');">Decline</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No applications found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $applications->links() }}
    </div>
</div>
@endsection
