@extends('layouts.admin')

@section('title', 'Job Applications')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Manage</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Job Applications</h2>
        </div>
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

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <span class="material-symbols-outlined text-yellow-600">hourglass_empty</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Pending</p>
                <p class="text-3xl font-black text-on-surface tracking-tighter">{{ $stats['pending'] }}</p>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600">search</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Reviewing</p>
                <p class="text-3xl font-black text-on-surface tracking-tighter">{{ $stats['reviewing'] }}</p>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-green-100 rounded-lg">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Accepted</p>
                <p class="text-3xl font-black text-on-surface tracking-tighter">{{ $stats['accepted'] }}</p>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-red-100 rounded-lg">
                    <span class="material-symbols-outlined text-red-600">cancel</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Declined</p>
                <p class="text-3xl font-black text-on-surface tracking-tighter">{{ $stats['declined'] }}</p>
            </div>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-6 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <p class="text-sm text-on-surface-variant">Total: {{ $stats['total'] }} applications</p>
        </div>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input type="text" name="search" class="w-full bg-surface-container-highest/50 border-none rounded-lg py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none" placeholder="Search by email or name..." value="{{ request('search') }}">
            </div>
            <div class="relative">
                <select name="status" class="w-full bg-surface-container-highest/50 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none appearance-none">
                    <option value="">All Statuses</option>
                    <option value="pending" @if(request('status') == 'pending') selected @endif>Pending</option>
                    <option value="reviewing" @if(request('status') == 'reviewing') selected @endif>Reviewing</option>
                    <option value="accepted" @if(request('status') == 'accepted') selected @endif>Accepted</option>
                    <option value="declined" @if(request('status') == 'declined') selected @endif>Declined</option>
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
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Position</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Applied</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @forelse($applications as $app)
                        <tr class="hover:bg-surface-container transition-colors">
                            <td class="px-6 py-4 font-bold text-on-surface">{{ $app->first_name }} {{ $app->last_name }}</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $app->email }}</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $app->phone }}</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $app->position }}</td>
                            <td class="px-6 py-4">
                                @if($app->status === 'pending')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-600"></span> Pending
                                    </span>
                                @elseif($app->status === 'reviewing')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span> Reviewing
                                    </span>
                                @elseif($app->status === 'accepted')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Accepted
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Declined
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $app->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.application.show', $app) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    @if($app->status === 'pending')
                                        <form action="{{ route('admin.application.review', $app) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Review">
                                                <span class="material-symbols-outlined text-[20px]">search</span>
                                            </button>
                                        </form>
                                    @endif
                                    @if($app->status !== 'accepted' && $app->status !== 'declined')
                                        <form action="{{ route('admin.application.accept', $app) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Accept" onclick="return confirm('Accept this application?');">
                                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.application.decline', $app) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Decline" onclick="return confirm('Decline this application?');">
                                                <span class="material-symbols-outlined text-[20px]">cancel</span>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                                <p>No applications found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($applications->hasPages())
        <div class="px-6 py-4 border-t border-surface-container">
            {{ $applications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection