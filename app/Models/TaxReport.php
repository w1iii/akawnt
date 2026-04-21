<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'client_email',
        'tax_type',
        'filing_status',
        'due_date',
        'amount',
        'report_date',
        'user_id',
        'client_id',
    ];

    protected $casts = [
        'due_date' => 'date',
        'report_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
