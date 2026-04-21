@extends('layouts.admin')

@section('title', 'Admin Management')

@php
    $isWhitelisted = \App\Models\AdminWhitelist::where('email', auth()->guard('admin')->user()->email)->exists();
@endphp

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Manage</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Admin Management</h2>
        </div>
        @if($isWhitelisted)
            <a href="{{ route('admin.management.create') }}" class="button button-primary">
                <span class="material-symbols-outlined">add</span>
                Add New Admin
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-red-600">error</span>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-surface-container-lowest p-6 rounded-xl">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input type="text" name="search" class="w-full bg-surface-container-highest/50 border-none rounded-lg py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none" placeholder="Search by name or email..." value="{{ request('search') }}">
            </div>
            <div class="relative">
                <select name="filter" class="w-full bg-surface-container-highest/50 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none appearance-none">
                    <option value="">All Admins</option>
                    <option value="verified" {{ request('filter') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="unverified" {{ request('filter') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
            </div>
            <button type="submit" class="button button-primary">Search</button>
        </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-surface-container">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Verified</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Created</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-surface-container transition-colors">
                            <td class="px-6 py-4 font-bold text-on-surface">{{ $admin->name }}</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $admin->email }}</td>
                            <td class="px-6 py-4">
                                @if($admin->email_verified_at)
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Yes
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> No
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $admin->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                @if($isWhitelisted)
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.management.edit', $admin) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <form action="{{ route('admin.management.destroy', $admin) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-on-surface-variant">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                                <p>No admins found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($admins->hasPages())
        <div class="px-6 py-4 border-t border-surface-container">
            {{ $admins->links() }}
        </div>
        @endif
    </div>
</div>
@endsection