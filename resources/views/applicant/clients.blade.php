@extends('layouts.applicant-new')

@section('title', 'Clients')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Manage</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Clients</h2>
        </div>
        <button type="button" class="button button-primary" data-bs-toggle="modal" data-bs-target="#addClientModal">
            <span class="material-symbols-outlined">add</span>
            Add Client
        </button>
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
                <input type="text" name="search" class="w-full bg-surface-container-highest/50 border-none rounded-lg py-2.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none" placeholder="Search by name, email, or company..." value="{{ request('search') }}">
            </div>
            <div class="relative">
                <select name="status" class="w-full bg-surface-container-highest/50 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none appearance-none">
                    <option value="">All Statuses</option>
                    <option value="active" @if(request('status') == 'active') selected @endif>Active</option>
                    <option value="inactive" @if(request('status') == 'inactive') selected @endif>Inactive</option>
                </select>
                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">
                Search
            </button>
        </form>
    </div>

    <div class="bg-surface-container-lowest rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-surface-container">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Name</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Company</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Services</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-surface-container">
                    @forelse($clients as $client)
                        <tr class="hover:bg-surface-container transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('applicant.clients.show', $client) }}" class="font-bold text-on-surface hover:text-primary">{{ $client->name }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $client->email }}</td>
                            <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $client->company_name ?: '-' }}</td>
                            <td class="px-6 py-4">
                                @if($client->services)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($client->services as $service)
                                            <span class="text-xs font-medium bg-surface-container px-2 py-1 rounded">{{ $service }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-sm text-on-surface-variant">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($client->status === 'active')
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('applicant.clients.show', $client) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="View">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    <a href="{{ route('applicant.clients.edit', $client) }}" class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <form action="{{ route('applicant.clients.destroy', $client) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" onclick="return confirm('Are you sure?');" title="Delete">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                                <p>No clients found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
        <div class="px-6 py-4 border-t border-surface-container">
            {{ $clients->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.modal { display: none; }
.modal.show { display: flex; }
</style>
<div class="modal fade" id="addClientModal" tabindex="-1" aria-labelledby="addClientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-xl">
            <div class="modal-header border-b border-surface-container px-8 py-4">
                <h5 class="modal-title text-xl font-bold text-on-surface" id="addClientModalLabel">Add New Client</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('applicant.clients.store') }}" method="POST">
                @csrf
                <div class="modal-body px-8 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Name *</label>
                            <input type="text" name="name" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Email *</label>
                            <input type="email" name="email" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Phone</label>
                            <input type="text" name="phone" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Company Name</label>
                            <input type="text" name="company_name" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-on-surface mb-2">Address</label>
                            <input type="text" name="address" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-on-surface mb-3">Services</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach(['Tax Preparation', 'Bookkeeping', 'Payroll', 'Audit', 'Financial Planning'] as $service)
                                    <label class="flex items-center gap-2 p-3 bg-surface-container rounded-lg cursor-pointer hover:bg-surface-container-high transition-colors">
                                        <input type="checkbox" name="services[]" value="{{ $service }}" class="w-4 h-4 text-primary rounded">
                                        <span class="text-sm">{{ $service }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-on-surface mb-2">Notes</label>
                            <textarea name="notes" rows="3" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-t border-surface-container px-8 py-4">
                    <button type="button" class="px-6 py-2.5 bg-surface-container text-on-surface text-sm font-bold rounded-lg hover:bg-surface-container-high transition-colors" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">Add Client</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection