@extends('layouts.applicant')

@section('title', 'Reports')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Reports</h1>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Report Type</label>
                <select name="type" class="form-select">
                    <option value="">Select Report Type</option>
                    <option value="client_summary" @if(request('type') == 'client_summary') selected @endif>Client Summary</option>
                    <option value="tax_report" @if(request('type') == 'tax_report') selected @endif>Tax Report</option>
                    <option value="audit_report" @if(request('type') == 'audit_report') selected @endif>Audit Report</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date Range</label>
                <select name="date_range" class="form-select">
                    <option value="">Select Date Range</option>
                    <option value="today" @if(request('date_range') == 'today') selected @endif>Today</option>
                    <option value="week" @if(request('date_range') == 'week') selected @endif>This Week</option>
                    <option value="month" @if(request('date_range') == 'month') selected @endif>This Month</option>
                    <option value="year" @if(request('date_range') == 'year') selected @endif>This Year</option>
                    <option value="custom" @if(request('date_range') == 'custom') selected @endif>Custom Range</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">Generate</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0">My Client Data Preview</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Client Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Last Activity</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">No data to preview. Generate a report to see data.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 text-end">
    <a href="#" class="btn btn-primary">
        <i class="bi bi-download me-2"></i>Download PDF
    </a>
</div>
@endsection