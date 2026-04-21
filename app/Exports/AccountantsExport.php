<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AccountantsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::where('role', 'accountant')
            ->orderBy('name')
            ->get()
            ->map(function ($user) {
                return [
                    'Name' => $user->name,
                    'Email' => $user->email,
                    'Status' => $user->last_activity_at && $user->last_activity_at >= now()->subMinutes(5) ? 'Online' : 'Offline',
                    'Last Activity' => $user->last_activity_at ? $user->last_activity_at->format('Y-m-d H:i:s') : 'Never',
                    'Created' => $user->created_at->format('Y-m-d'),
                ];
            });
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Status', 'Last Activity', 'Created'];
    }
}
