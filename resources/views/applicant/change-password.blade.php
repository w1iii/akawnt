@extends('layouts.applicant-new')

@section('title', 'Change Password')

@section('content')
<div class="space-y-8 max-w-2xl">
    <div>
        <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Security</p>
        <h2 class="text-4xl font-extrabold text-primary tracking-tight">Change Password</h2>
    </div>

    <div class="bg-surface-container-lowest p-8 rounded-xl">
        <form method="POST" action="{{ route('applicant.password.update') }}">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Current Password</label>
                    <input type="password" name="current_password" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">New Password</label>
                    <input type="password" name="password" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Confirm New Password</label>
                    <input type="password" name="password_confirmation" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-3 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">
                        Update Password
                    </button>
                    <a href="{{ route('applicant.dashboard') }}" class="px-6 py-3 bg-surface-container text-on-surface text-sm font-bold rounded-lg hover:bg-surface-container-high transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection