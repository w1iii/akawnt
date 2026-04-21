<?php

namespace App\Exports;

use App\Models\JobApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobApplicationsExport implements FromCollection, WithHeadings
{
    protected $status;

    public function __construct($status = null)
    {
        $this->status = $status;
    }

    public function collection()
    {
        $query = JobApplication::query();

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query->orderBy('created_at', 'desc')->get()->map(function ($app) {
            return [
                'Name' => $app->first_name.' '.$app->last_name,
                'Email' => $app->email,
                'Phone' => $app->phone,
                'Position' => $app->position,
                'Status' => ucfirst($app->status),
                'Applied Date' => $app->created_at->format('Y-m-d'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Phone', 'Position', 'Status', 'Applied Date'];
    }
}
