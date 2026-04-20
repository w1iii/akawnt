@extends('layouts.applicant-new')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-10">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Overview</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Atelier Performance</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-tertiary-container/20 rounded-lg">
                    <span class="material-symbols-outlined text-tertiary">group</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Total Clients</p>
                <p class="text-2xl font-black text-on-surface tracking-tighter">{{ $clientsCount ?? 0 }}</p>
            </div>
            <div class="h-1 w-full bg-surface-container rounded-full overflow-hidden">
                <div class="h-full bg-tertiary w-3/4"></div>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-green-100 rounded-lg">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Active Clients</p>
                <p class="text-2xl font-black text-on-surface tracking-tighter">{{ $activeClientsCount ?? 0 }}</p>
            </div>
            <div class="h-1 w-full bg-surface-container rounded-full overflow-hidden">
                <div class="h-full bg-green-500 w-2/3"></div>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-secondary-container/30 rounded-lg">
                    <span class="material-symbols-outlined text-secondary">description</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Tax Reports</p>
                <p class="text-2xl font-black text-on-surface tracking-tighter">{{ $taxReportsCount ?? 0 }}</p>
            </div>
            <div class="h-1 w-full bg-surface-container rounded-full overflow-hidden">
                <div class="h-full bg-secondary w-1/2"></div>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-primary-container/30 rounded-lg">
                    <span class="material-symbols-outlined text-primary">fact_check</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Audit Reports</p>
                <p class="text-2xl font-black text-on-surface tracking-tighter">{{ $auditReportsCount ?? 0 }}</p>
            </div>
            <div class="h-1 w-full bg-surface-container rounded-full overflow-hidden">
                <div class="h-full bg-primary w-1/3"></div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-xl space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-on-surface">Your Profile</h3>
                    <p class="text-sm text-on-surface-variant">Manage your account information</p>
                </div>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center gap-4 p-4 bg-surface-container rounded-lg">
                    <div class="w-12 h-12 rounded-full bg-primary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary">person</span>
                    </div>
                    <div>
                        <p class="font-bold text-on-surface">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-on-surface-variant">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Member Since</p>
                        <p class="font-bold text-on-surface">{{ Auth::user()->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
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
                            <span class="text-xs text-on-surface-variant">No application</span>
                        @endif
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <a href="{{ route('applicant.profile.edit') }}" class="flex-1 px-4 py-3 bg-primary text-on-primary text-sm font-bold rounded-lg flex items-center justify-center gap-2 hover:bg-primary-dim transition-colors">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                        Edit Profile
                    </a>
                    <a href="{{ route('applicant.password.change') }}" class="flex-1 px-4 py-3 bg-surface-container text-on-surface text-sm font-bold rounded-lg flex items-center justify-center gap-2 hover:bg-surface-container-high transition-colors">
                        <span class="material-symbols-outlined text-[18px]">lock</span>
                        Change Password
                    </a>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-primary p-8 rounded-xl text-on-primary relative overflow-hidden">
                <div class="relative z-10 space-y-4">
                    <h3 class="text-xl font-bold tracking-tight">Quick Actions</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <a href="{{ route('applicant.clients') }}" class="w-full bg-on-primary text-primary px-4 py-3 rounded-lg font-bold flex items-center justify-between hover:scale-[1.02] transition-transform">
                            <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[20px]">person_add</span> Add Client</span>
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </a>
                        <a href="{{ route('applicant.reports') }}" class="w-full bg-primary-dim text-on-primary px-4 py-3 rounded-lg font-bold flex items-center justify-between border border-on-primary/20 hover:bg-on-primary/10 transition-colors">
                            <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[20px]">lab_profile</span> Run Report</span>
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </a>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-on-primary/5 rounded-full blur-2xl"></div>
            </div>

            <div class="bg-surface-container p-6 rounded-xl border border-outline-variant/10">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-tertiary">verified_user</span>
                    <span class="text-sm font-bold text-on-surface">Account Status</span>
                </div>
                <div class="flex items-end gap-2">
                    <p class="text-3xl font-black text-on-surface">Active</p>
                </div>
                <p class="text-[10px] text-on-surface-variant mt-2">Your account is in good standing.</p>
            </div>
        </div>
    </div>
</div>
@endsection