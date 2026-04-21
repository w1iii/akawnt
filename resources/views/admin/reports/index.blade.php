@extends('layouts.admin')

@section('title', 'Reports')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Manage</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Reports</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600">assignment</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Total Applications</p>
                <p class="text-3xl font-black text-on-surface tracking-tighter">{{ $stats['total_applications'] }}</p>
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
                <div class="p-2 bg-purple-100 rounded-lg">
                    <span class="material-symbols-outlined text-purple-600">group</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Online Accountants</p>
                <p class="text-3xl font-black text-on-surface tracking-tighter">{{ $stats['online_accountants'] }} / {{ $stats['total_accountants'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600">assignment</span>
                </div>
                <div>
                    <p class="text-lg font-bold text-on-surface">Job Applications</p>
                    <p class="text-sm text-on-surface-variant">Export all applications data</p>
                </div>
            </div>
            <div class="space-y-4">
                <form method="GET" action="{{ route('admin.reports.applications.excel') }}">
                    <input type="hidden" name="status" value="">
                    <button type="submit" class="button button-secondary w-full justify-start gap-3">
                        <span class="material-symbols-outlined">table</span>
                        Export to Excel (All)
                    </button>
                </form>
                <form method="GET" action="{{ route('admin.reports.applications.excel') }}">
                    <input type="hidden" name="status" value="pending">
                    <button type="submit" class="button button-secondary w-full justify-start gap-3">
                        <span class="material-symbols-outlined">table</span>
                        Export to Excel (Pending)
                    </button>
                </form>
                <form method="GET" action="{{ route('admin.reports.applications.excel') }}">
                    <input type="hidden" name="status" value="accepted">
                    <button type="submit" class="button button-secondary w-full justify-start gap-3">
                        <span class="material-symbols-outlined">table</span>
                        Export to Excel (Accepted)
                    </button>
                </form>
                <a href="{{ route('admin.reports.applications.pdf') }}" class="button button-secondary w-full justify-start gap-3">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                    Export to PDF (All)
                </a>
                <a href="{{ route('admin.reports.applications.pdf') }}?status=accepted" class="button button-secondary w-full justify-start gap-3">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                    Export to PDF (Accepted)
                </a>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-2 bg-green-100 rounded-lg">
                    <span class="material-symbols-outlined text-green-600">group</span>
                </div>
                <div>
                    <p class="text-lg font-bold text-on-surface">Accountants</p>
                    <p class="text-sm text-on-surface-variant">Export accountants data</p>
                </div>
            </div>
            <div class="space-y-4">
                <a href="{{ route('admin.reports.accountants.excel') }}" class="button button-secondary w-full justify-start gap-3">
                    <span class="material-symbols-outlined">table</span>
                    Export to Excel
                </a>
                <a href="{{ route('admin.reports.accountants.pdf') }}" class="button button-secondary w-full justify-start gap-3">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                    Export to PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection