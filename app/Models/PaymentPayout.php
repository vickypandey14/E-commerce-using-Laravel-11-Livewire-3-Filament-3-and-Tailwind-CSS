<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPayout extends Model
{
    use HasFactory;

    protected $table = 'payment_payouts';

    protected $fillable = [
        'gateway_code',
        'gateway_payout_id',
        'amount',
        'currency',
        'status',
        'arrival_date',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'arrival_date' => 'datetime',
        'metadata' => 'array',
    ];
}
