@extends('layouts.admin')

@section('title', 'Edit Accountant')

@section('content')
<div class="space-y-8 max-w-2xl">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Manage</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Edit Accountant</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.accountants.show', $accountant) }}" class="button button-info">View Details</a>
            <a href="{{ route('admin.accountants.index') }}" class="button button-secondary">Back</a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface-container-lowest p-8 rounded-xl">
        <form method="POST" action="{{ route('admin.accountants.update', $accountant) }}">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $accountant->name) }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email', $accountant->email) }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @else
                        <p class="text-on-surface-variant text-xs mt-1">This email will be used for login and notifications.</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Password <span class="text-on-surface-variant font-normal">(leave blank to keep current)</span></label>
                    <input type="password" name="password" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @else
                        <p class="text-on-surface-variant text-xs mt-1">Password must be at least 8 characters long if changing.</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="button button-primary">Update Accountant</button>
                    <a href="{{ route('admin.accountants.show', $accountant) }}" class="button button-info">View Details</a>
                    <a href="{{ route('admin.accountants.index') }}" class="button button-secondary">Back to List</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection