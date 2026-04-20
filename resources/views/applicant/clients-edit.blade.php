@extends('layouts.applicant-new')

@section('title', 'Edit Client')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Client</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Edit Client</h2>
        </div>
        <a href="{{ route('applicant.clients.show', $client) }}" class="px-6 py-3 bg-surface-container text-on-surface text-sm font-bold rounded-lg flex items-center gap-2 hover:bg-surface-container-high transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Back to Client
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface-container-lowest p-8 rounded-xl">
        <form action="{{ route('applicant.clients.update', $client) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Name *</label>
                    <input type="text" name="name" value="{{ old('name', $client->name) }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $client->email) }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $client->phone) }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $client->company_name) }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-on-surface mb-2">Address</label>
                    <input type="text" name="address" value="{{ old('address', $client->address) }}" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-sm font-bold text-on-surface mb-2">Status *</label>
                    <div class="relative">
                        <select name="status" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all appearance-none" required>
                            <option value="active" @if(old('status', $client->status) == 'active') selected @endif>Active</option>
                            <option value="inactive" @if(old('status', $client->status) == 'inactive') selected @endif>Inactive</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-on-surface mb-3">Services</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach(['Tax Preparation', 'Bookkeeping', 'Payroll', 'Audit', 'Financial Planning'] as $service)
                            <label class="flex items-center gap-2 p-3 bg-surface-container rounded-lg cursor-pointer hover:bg-surface-container-high transition-colors">
                                <input type="checkbox" name="services[]" value="{{ $service }}" @if(in_array($service, old('services', $client->services ?? []))) checked @endif class="w-4 h-4 text-primary rounded">
                                <span class="text-sm">{{ $service }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-on-surface mb-2">Notes</label>
                    <textarea name="notes" rows="4" class="w-full bg-surface-container-highest/50 border border-outline-variant/20 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition-all">{{ old('notes', $client->notes) }}</textarea>
                </div>
                <div class="md:col-span-2 flex gap-3 pt-2">
                    <button type="submit" class="px-6 py-3 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">
                        Update Client
                    </button>
                    <a href="{{ route('applicant.clients.show', $client) }}" class="px-6 py-3 bg-surface-container text-on-surface text-sm font-bold rounded-lg hover:bg-surface-container-high transition-colors">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection