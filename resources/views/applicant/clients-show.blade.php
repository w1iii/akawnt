@extends('layouts.applicant-new')

@section('title', 'Client Details')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Client</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">{{ $client->name }}</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('applicant.clients.edit', $client) }}" class="px-6 py-3 bg-primary text-on-primary text-sm font-bold rounded-lg flex items-center gap-2 hover:bg-primary-dim transition-colors">
                <span class="material-symbols-outlined text-[18px]">edit</span>
                Edit Client
            </a>
            <a href="{{ route('applicant.clients') }}" class="px-6 py-3 bg-surface-container text-on-surface text-sm font-bold rounded-lg flex items-center gap-2 hover:bg-surface-container-high transition-colors">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to List
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
                    <h3 class="text-lg font-bold text-on-surface">Client Information</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Name</p>
                        <p class="font-bold text-on-surface">{{ $client->name }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Email</p>
                        <p class="font-bold text-on-surface">{{ $client->email }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Phone</p>
                        <p class="font-bold text-on-surface">{{ $client->phone ?: '-' }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Company</p>
                        <p class="font-bold text-on-surface">{{ $client->company_name ?: '-' }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg md:col-span-2">
                        <p class="text-xs text-on-surface-variant mb-1">Address</p>
                        <p class="font-bold text-on-surface">{{ $client->address ?: '-' }}</p>
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Status</p>
                        @if($client->status === 'active')
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Inactive
                            </span>
                        @endif
                    </div>
                    <div class="p-4 bg-surface-container rounded-lg">
                        <p class="text-xs text-on-surface-variant mb-1">Services</p>
                        @if($client->services)
                            <div class="flex flex-wrap gap-1 mt-1">
                                @foreach($client->services as $service)
                                    <span class="text-xs font-medium bg-surface-container-highest px-2 py-1 rounded">{{ $service }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="font-bold text-on-surface">-</p>
                        @endif
                    </div>
                </div>
            </div>

            @if($client->notes)
            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-primary">note</span>
                    <h3 class="text-lg font-bold text-on-surface">Notes</h3>
                </div>
                <p class="text-on-surface-variant">{{ $client->notes }}</p>
            </div>
            @endif

            <div class="bg-surface-container-lowest p-6 rounded-xl">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">history</span>
                        <h3 class="text-lg font-bold text-on-surface">Activity History</h3>
                    </div>
                    <button type="button" class="px-4 py-2 bg-primary text-on-primary text-sm font-bold rounded-lg flex items-center gap-2 hover:bg-primary-dim transition-colors" data-bs-toggle="modal" data-bs-target="#addActivityModal">
                        <span class="material-symbols-outlined text-[18px]">add</span>
                        Add Activity
                    </button>
                </div>
                
                @if($client->activities->count() > 0)
                    <div class="space-y-3">
                        @foreach($client->activities as $activity)
                            <div class="flex items-start gap-4 p-4 bg-surface-container rounded-lg">
                                <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center flex-shrink-0">
                                    @if($activity->type === 'call')
                                        <span class="material-symbols-outlined text-primary">call</span>
                                    @elseif($activity->type === 'email')
                                        <span class="material-symbols-outlined text-primary">email</span>
                                    @elseif($activity->type === 'meeting')
                                        <span class="material-symbols-outlined text-primary">groups</span>
                                    @elseif($activity->type === 'document')
                                        <span class="material-symbols-outlined text-primary">description</span>
                                    @elseif($activity->type === 'payment')
                                        <span class="material-symbols-outlined text-primary">payments</span>
                                    @else
                                        <span class="material-symbols-outlined text-primary">event</span>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="font-bold text-on-surface capitalize">{{ str_replace('-', ' ', $activity->type) }}</p>
                                        <span class="text-xs text-on-surface-variant">{{ $activity->created_at->format('M d, Y \a\t h:i A') }}</span>
                                    </div>
                                    <p class="text-sm text-on-surface-variant">{{ $activity->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-2">history</span>
                        <p class="text-on-surface-variant">No activity recorded yet.</p>
                    </div>
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
                    <a href="{{ route('applicant.clients.edit', $client) }}" class="w-full px-4 py-3 bg-primary text-on-primary text-sm font-bold rounded-lg flex items-center justify-between hover:bg-primary-dim transition-colors">
                        <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[20px]">edit</span> Edit Client</span>
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </a>
                    <form action="{{ route('applicant.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client? This action cannot be undone.');" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-3 bg-red-50 text-red-600 text-sm font-bold rounded-lg flex items-center justify-between hover:bg-red-100 transition-colors">
                            <span class="flex items-center gap-2"><span class="material-symbols-outlined text-[20px]">delete</span> Delete Client</span>
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-surface-container p-6 rounded-xl">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-on-surface-variant">info</span>
                    <h3 class="text-sm font-bold text-on-surface">Client Info</h3>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Created</span>
                        <span class="font-medium text-on-surface">{{ $client->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-on-surface-variant">Last Updated</span>
                        <span class="font-medium text-on-surface">{{ $client->updated_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addActivityModal" tabindex="-1" aria-labelledby="addActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-xl">
            <div class="modal-header border-b border-surface-container px-6 py-4">
                <h5 class="modal-title text-lg font-bold text-on-surface" id="addActivityModalLabel">Add Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('applicant.clients.activities.store', $client) }}" method="POST">
                @csrf
                <div class="modal-body px-6 py-4">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Activity Type *</label>
                            <select name="type" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                                <option value="">Select Type</option>
                                <option value="call">Phone Call</option>
                                <option value="email">Email</option>
                                <option value="meeting">Meeting</option>
                                <option value="document">Document</option>
                                <option value="payment">Payment</option>
                                <option value="follow-up">Follow-up</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-on-surface mb-2">Description *</label>
                            <textarea name="description" rows="4" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-t border-surface-container px-6 py-4">
                    <button type="button" class="px-6 py-2.5 bg-surface-container text-on-surface text-sm font-bold rounded-lg hover:bg-surface-container-high transition-colors" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">Add Activity</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection