<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Accountants Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        .meta { color: #666; font-size: 11px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 10px; }
        th { background: #f5f5f5; font-weight: bold; }
        .online { color: #28a745; font-weight: bold; }
        .offline { color: #dc3545; }
    </style>
</head>
<body>
    <h1>Accountants Report</h1>
    <p class="meta">Generated on {{ date('F d, Y') }} - Total: {{ $accountants->count() }}</p>
    
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Last Activity</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accountants as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td class="{{ $user->last_activity_at && $user->last_activity_at >= \Carbon\Carbon::now()->subMinutes(5) ? 'online' : 'offline' }}">
                    {{ $user->last_activity_at && $user->last_activity_at >= \Carbon\Carbon::now()->subMinutes(5) ? 'Online' : 'Offline' }}
                </td>
                <td>{{ $user->last_activity_at ? $user->last_activity_at->format('Y-m-d H:i') : 'Never' }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>