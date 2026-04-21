@extends('layouts.admin')

@section('title', 'Create Admin')

@section('content')
<div class="space-y-8 max-w-2xl">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Manage</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Create Admin</h2>
        </div>
        <a href="{{ route('admin.management.index') }}" class="button button-secondary">
            <span class="material-symbols-outlined">arrow_back</span>
            Back
        </a>
    </div>

    <div class="bg-surface-container-lowest p-8 rounded-xl">
        <form method="POST" action="{{ route('admin.management.store') }}">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('name') border-red-500 @enderror" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('email') border-red-500 @enderror" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Password</label>
                    <input type="password" name="password" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all @error('password') border-red-500 @enderror" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="button button-primary">Create Admin</button>
                    <a href="{{ route('admin.management.index') }}" class="button button-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection