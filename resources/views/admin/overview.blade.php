@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <p class="text-label-sm text-on-surface-variant tracking-[0.1em] uppercase font-semibold mb-1">Welcome back</p>
            <h2 class="text-4xl font-extrabold text-primary tracking-tight">Dashboard</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl space-y-4">
            <div class="flex justify-between items-start">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <span class="material-symbols-outlined text-blue-600">group</span>
                </div>
            </div>
            <div>
                <p class="text-on-surface-variant text-sm font-medium">Accountants</p>
                <p class="text-3xl font-black text-on-surface tracking-tighter">{{ $stats['accountants'] }}</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-surface-container-lowest p-6 rounded-xl">
            <p class="text-lg font-bold text-on-surface mb-4">Applications (Last 30 Days)</p>
            <div class="h-64">
                <canvas id="applicationsChart"></canvas>
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl">
            <p class="text-lg font-bold text-on-surface mb-4">Accountants Activity (Last 30 Days)</p>
            <div class="h-64">
                <canvas id="accountantsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-surface-container-lowest rounded-xl overflow-hidden">
            <div class="p-6 border-b border-surface-container">
                <div class="flex justify-between items-center">
                    <p class="text-lg font-bold text-on-surface">Recent Applications</p>
                    <a href="{{ route('admin.applications.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">View all</a>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-container">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Applied</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-on-surface-variant uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-container">
                        @forelse($recentApplications as $app)
                            <tr class="hover:bg-surface-container transition-colors">
                                <td class="px-6 py-4 font-bold text-on-surface">{{ $app->first_name }} {{ $app->last_name }}</td>
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
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-4xl mb-2">folder_off</span>
                                    <p>No recent applications</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-surface-container-lowest rounded-xl p-6">
                <p class="text-lg font-bold text-on-surface mb-4">Online Now</p>
                <div class="space-y-3">
                    @forelse($onlineAccountants as $accountant)
                        <div class="flex items-center gap-3 p-3 bg-surface-container rounded-lg">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-green-600">{{ substr($accountant->name, 0, 1) }}</span>
                                </div>
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-on-surface truncate">{{ $accountant->name }}</p>
                                <p class="text-xs text-on-surface-variant">Active {{ $accountant->last_activity_at->diffInSeconds(now()) }}s ago</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-on-surface-variant">No accountants online</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-surface-container-lowest rounded-xl p-6">
                <p class="text-lg font-bold text-on-surface mb-6">Quick Actions</p>
                <div class="space-y-3">
                    <a href="{{ route('admin.applications.index') }}" class="flex items-center gap-3 p-4 bg-surface-container hover:bg-surface-container-high rounded-lg transition-colors">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <span class="material-symbols-outlined text-blue-600">assignment</span>
                        </div>
                        <div>
                            <p class="font-medium text-on-surface">View Applications</p>
                            <p class="text-sm text-on-surface-variant">{{ $stats['total'] }} total applications</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.accountants.create') }}" class="flex items-center gap-3 p-4 bg-surface-container hover:bg-surface-container-high rounded-lg transition-colors">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <span class="material-symbols-outlined text-green-600">person_add</span>
                        </div>
                        <div>
                            <p class="font-medium text-on-surface">Add Accountant</p>
                            <p class="text-sm text-on-surface-variant">Create new account</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.management.create') }}" class="flex items-center gap-3 p-4 bg-surface-container hover:bg-surface-container-high rounded-lg transition-colors">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <span class="material-symbols-outlined text-purple-600">admin_panel_settings</span>
                        </div>
                        <div>
                            <p class="font-medium text-on-surface">Add Admin</p>
                            <p class="text-sm text-on-surface-variant">Create new admin user</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#566166';

    const applicationsCtx = document.getElementById('applicationsChart');
    if (applicationsCtx) {
        new Chart(applicationsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['applications']['labels']) !!},
                datasets: [{
                    label: 'Applications',
                    data: {!! json_encode($chartData['applications']['data']) !!},
                    borderColor: '#545f73',
                    backgroundColor: 'rgba(84, 95, 115, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { maxTicks: 7 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e8eff3' }
                    }
                }
            }
        });
    }

    const accountantsCtx = document.getElementById('accountantsChart');
    if (accountantsCtx) {
        new Chart(accountantsCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData['accountants']['labels']) !!},
                datasets: [{
                    label: 'Active Accountants',
                    data: {!! json_encode($chartData['accountants']['data']) !!},
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { maxTicks: 7 }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e8eff3' }
                    }
                }
            }
        });
    }
});
</script>
@endsection