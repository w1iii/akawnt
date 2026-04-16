@extends('layouts.admin')

@section('title', 'Admin Management')

@php
    $isWhitelisted = \App\Models\AdminWhitelist::where('email', auth()->guard('admin')->user()->email)->exists();
@endphp

@section('content')
<div class="page-header">
    <h1>Admin Management</h1>
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

@if($isWhitelisted)
<div class="page-actions">
    <a href="{{ route('admin.management.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Admin
    </a>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="filter" class="form-select">
                    <option value="">All Admins</option>
                    <option value="verified" {{ request('filter') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="unverified" {{ request('filter') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Verified</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr>
                            <td>{{ $admin->name }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                @if($admin->email_verified_at)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>{{ $admin->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($isWhitelisted)
                                    <a href="{{ route('admin.management.edit', $admin) }}" class="btn btn-sm btn-info">Edit</a>
                                    <form action="{{ route('admin.management.destroy', $admin) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">No admins found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $admins->links() }}
        </div>
    </div>
</div>
@endsection
