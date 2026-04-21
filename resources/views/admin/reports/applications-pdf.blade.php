<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Job Applications Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        .meta { color: #666; font-size: 11px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; }
        th { background: #f5f5f5; font-weight: bold; }
        .status-pending { background: #fff3cd; }
        .status-reviewing { background: #cce5ff; }
        .status-accepted { background: #d4edda; }
        .status-declined { background: #f8d7da; }
    </style>
</head>
<body>
    <h1>Job Applications Report</h1>
    <p class="meta">Generated on {{ date('F d, Y') }} @if($status) - Status: {{ ucfirst($status) }} @endif - Total: {{ $applications->count() }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Status</th>
                <th>Applied Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $app)
            <tr class="status-{{ $app->status }}">
                <td>{{ $app->first_name }} {{ $app->last_name }}</td>
                <td>{{ $app->email }}</td>
                <td>{{ $app->phone }}</td>
                <td>{{ $app->position }}</td>
                <td>{{ ucfirst($app->status) }}</td>
                <td>{{ $app->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>