@extends('layouts.applicant-new')

@section('title', 'Reports')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Analytics</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Reports</h2>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <span class="material-symbols-outlined text-green-600">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-surface-container-lowest p-6 rounded-xl">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Report Type</label>
                <div class="relative">
                    <select name="type" class="w-full bg-surface-container-highest/50 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none appearance-none" onchange="this.form.submit()">
                        <option value="client_summary" @if($type == 'client_summary') selected @endif>Client Summary</option>
                        <option value="tax_report" @if($type == 'tax_report') selected @endif>Tax Report</option>
                        <option value="audit_report" @if($type == 'audit_report') selected @endif>Audit Report</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-on-surface mb-2">Date Range</label>
                <div class="relative">
                    <select name="date_range" class="w-full bg-surface-container-highest/50 border-none rounded-lg py-2.5 px-4 text-sm focus:ring-2 focus:ring-slate-200 transition-all outline-none appearance-none" onchange="this.form.submit()">
                        <option value="today" @if($dateRange == 'today') selected @endif>Today</option>
                        <option value="week" @if($dateRange == 'week') selected @endif>This Week</option>
                        <option value="month" @if($dateRange == 'month') selected @endif>This Month</option>
                        <option value="year" @if($dateRange == 'year') selected @endif>This Year</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none">expand_more</span>
                </div>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">
                    Generate
                </button>
            </div>
        </form>
    </div>

    @if($type === 'client_summary')
        <div class="bg-surface-container-lowest rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-surface-container">
                <h3 class="text-xl font-bold text-on-surface">Client Summary Report</h3>
                <p class="text-sm text-on-surface-variant">Overview of all your clients</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-container">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Client Name</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Company</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Services</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Activities</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Last Activity</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @forelse($data as $client)
                            <tr class="hover:bg-surface-container transition-colors">
                                <td class="px-6 py-4 font-bold text-on-surface">{{ $client['client_name'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $client['email'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $client['company'] ?: '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($client['services'])
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($client['services'] as $service)
                                                <span class="text-xs font-medium bg-surface-container px-2 py-1 rounded">{{ $service }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm text-on-surface-variant">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($client['status'] === 'active')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $client['total_activities'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $client['last_activity'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                                    <p>No clients found for this period.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($type === 'tax_report')
        <div class="bg-surface-container-lowest rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-surface-container">
                <h3 class="text-xl font-bold text-on-surface">Tax Report</h3>
                <p class="text-sm text-on-surface-variant">Tax filings and status</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-container">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Tax Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Report Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @forelse($data as $report)
                            <tr class="hover:bg-surface-container transition-colors">
                                <td class="px-6 py-4 font-bold text-on-surface">{{ $report['client_name'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report['client_email'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report['tax_type'] }}</td>
                                <td class="px-6 py-4">
                                    @if($report['filing_status'] === 'Filed')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Filed
                                        </span>
                                    @elseif($report['filing_status'] === 'Pending')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-600"></span> Pending
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> {{ $report['filing_status'] }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report['due_date'] }}</td>
                                <td class="px-6 py-4 font-bold text-on-surface">{{ $report['amount'] ? '$' . number_format($report['amount'], 2) : '-' }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report['report_date'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                                    <p>No tax reports found for this period.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @elseif($type === 'audit_report')
        <div class="bg-surface-container-lowest rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-surface-container">
                <h3 class="text-xl font-bold text-on-surface">Audit Report</h3>
                <p class="text-sm text-on-surface-variant">Audit engagements and status</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-container">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Audit Type</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Start Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">End Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @forelse($data as $report)
                            <tr class="hover:bg-surface-container transition-colors">
                                <td class="px-6 py-4 font-bold text-on-surface">{{ $report['client_name'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report['client_email'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report['audit_type'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report['start_date'] }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">{{ $report['end_date'] }}</td>
                                <td class="px-6 py-4">
                                    @if($report['status'] === 'completed')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-600"></span> Completed
                                        </span>
                                    @elseif($report['status'] === 'in_progress')
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span> In Progress
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-xs font-bold text-yellow-600 bg-yellow-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-600"></span> Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                                    <p>No audit reports found for this period.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="flex justify-end">
        <button type="button" onclick="document.getElementById('downloadModal').classList.remove('hidden')" class="px-6 py-3 bg-primary text-on-primary text-sm font-bold rounded-full shadow-lg flex items-center gap-2 hover:bg-primary-dim transition-transform">
            <span class="material-symbols-outlined text-[18px]">download</span>
            Download PDF
        </button>
    </div>
</div>

<div id="downloadModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
        <div class="border-b border-surface-container px-6 py-4 flex items-center justify-between">
            <h5 class="text-lg font-bold text-on-surface">Download Report</h5>
            <button onclick="document.getElementById('downloadModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="px-6 py-4">
            <p class="text-on-surface-variant mb-4">Are you sure you want to download this report?</p>
            <div class="bg-surface-container p-4 rounded-lg">
                <p><strong class="text-on-surface">Report Type:</strong> <span class="text-on-surface-variant">{{ ucfirst(str_replace('_', ' ', $type)) }}</span></p>
                <p><strong class="text-on-surface">Date Range:</strong> <span class="text-on-surface-variant">{{ ucfirst($dateRange) }}</span></p>
            </div>
        </div>
        <div class="border-t border-surface-container px-6 py-4 flex items-center justify-end gap-3">
            <button onclick="document.getElementById('downloadModal').classList.add('hidden')" class="px-6 py-2.5 bg-surface-container text-on-surface text-sm font-bold rounded-lg hover:bg-surface-container-high transition-colors">Cancel</button>
            <form method="GET" action="{{ route('applicant.reports.download') }}" target="_blank">
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="date_range" value="{{ $dateRange }}">
                <button type="submit" class="px-6 py-2.5 bg-primary text-on-primary text-sm font-bold rounded-lg hover:bg-primary-dim transition-colors">Confirm Download</button>
            </form>
        </div>
    </div>
</div>
@endsection