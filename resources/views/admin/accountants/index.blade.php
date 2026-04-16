@extends('layouts.admin')

@section('title', 'Accountant Management')

@section('content')
<div class="page-header">
    <h1>Accountant Management</h1>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="page-actions">
    <a href="{{ route('admin.accountants.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Accountant
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-8">
                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Applications</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accountants as $accountant)
                        <tr>
                            <td>{{ $accountant->name }}</td>
                            <td>{{ $accountant->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $accountant->jobApplications->count() }}</span>
                            </td>
                            <td>{{ $accountant->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.accountants.show', $accountant) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.accountants.edit', $accountant) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.accountants.destroy', $accountant) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this accountant?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No accountants found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $accountants->links() }}
        </div>
    </div>
</div>
@endsection