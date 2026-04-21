@extends('layouts.applicant-new')

@section('title', 'Settings')

@section('content')
<div class="space-y-8">
    <div>
        <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Account</p>
        <h2 class="text-4xl font-extrabold text-primary tracking-tight">Settings</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="text-lg font-bold text-on-surface">Profile Information</h3>
                </div>
                
                <form method="POST" action="{{ route('applicant.profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-on-surface mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-on-surface mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary">lock</span>
                    <h3 class="text-lg font-bold text-on-surface">Change Password</h3>
                </div>
                
                <form method="POST" action="{{ route('applicant.password.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Current Password</label>
                            <input type="password" name="current_password" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-on-surface mb-2">New Password</label>
                                <input type="password" name="password" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-on-surface mb-2">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">
                                Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-tertiary">verified_user</span>
                    <h3 class="text-lg font-bold text-on-surface">Account Status</h3>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600">check_circle</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface">Active</p>
                            <p class="text-xs text-on-surface-variant">Your account is in good standing</p>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-surface-container">
                        <p class="text-xs text-on-surface-variant mb-1">Member Since</p>
                        <p class="font-bold text-on-surface">{{ Auth::user()->created_at->format('F d, Y') }}</p>
                    </div>
                    <div class="pt-4 border-t border-surface-container">
                        <p class="text-xs text-on-surface-variant mb-1">Application Status</p>
                        @if($application)
                            @if($application->status === 'accepted')
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Accepted
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-600"></span> {{ ucfirst($application->status) }}
                                </span>
                            @endif
                        @else
                            <span class="text-sm text-on-surface-variant">No application</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-surface-container p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-on-surface-variant">info</span>
                    <h3 class="text-sm font-bold text-on-surface">Account Info</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Email</span>
                        <span class="font-medium text-on-surface">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Role</span>
                        <span class="font-medium text-on-surface capitalize">{{ Auth::user()->role }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Client Count</span>
                        <span class="font-medium text-on-surface">{{ $clientsCount ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection