@extends('layouts.admin')

@section('title', 'Accountant Details')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Accountant</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">{{ $accountant->name }}</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.accountants.edit', $accountant) }}" class="button button-warning">
                <span class="material-symbols-outlined">edit</span>
                Edit
            </a>
            <a href="{{ route('admin.accountants.index') }}" class="button button-secondary">
                <span class="material-symbols-outlined">arrow_back</span>
                Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="text-lg font-bold text-on-surface">Accountant Information</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Name</p>
                        <p class="font-bold text-on-surface">{{ $accountant->name }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Email</p>
                        <p class="font-bold text-on-surface">{{ $accountant->email }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Role</p>
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-primary bg-primary-container px-2 py-1 rounded-full">
                            {{ ucfirst($accountant->role) }}
                        </span>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Member Since</p>
                        <p class="font-bold text-on-surface">{{ $accountant->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">work</span>
                    <h3 class="text-lg font-bold text-on-surface">Job Applications</h3>
                </div>
                
                @if($accountant->jobApplications->count() > 0)
                    <div class="space-y-3">
                        @foreach($accountant->jobApplications as $application)
                            <div class="flex items-center justify-between p-4 bg-surface-container rounded-lg">
                                <div>
                                    <p class="font-bold text-on-surface">{{ $application->position }}</p>
                                    <p class="text-sm text-on-surface-variant">{{ $application->created_at->format('M d, Y') }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($application->status === 'pending')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-600"></span> Pending
                                        </span>
                                    @elseif($application->status === 'reviewing')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span> Reviewing
                                        </span>
                                    @elseif($application->status === 'accepted')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Accepted
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Declined
                                        </span>
                                    @endif
                                    <a href="{{ route('admin.application.show', $application) }}" class="button button-info text-xs py-2 px-3">View</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-on-surface-variant text-center py-4">No job applications found for this accountant.</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">flash_on</span>
                    <h3 class="text-lg font-bold text-on-surface">Quick Actions</h3>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('admin.accountants.edit', $accountant) }}" class="button button-warning w-full justify-between">
                        <span class="flex items-center gap-2"><span class="material-symbols-outlined">edit</span> Edit Accountant</span>
                        <span class="material-symbols-outlined">chevron_right</span>
                    </a>
                    <form action="{{ route('admin.accountants.destroy', $accountant) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this accountant? This action cannot be undone.');" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button button-danger w-full justify-between">
                            <span class="flex items-center gap-2"><span class="material-symbols-outlined">delete</span> Delete Accountant</span>
                            <span class="material-symbols-outlined">chevron_right</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection