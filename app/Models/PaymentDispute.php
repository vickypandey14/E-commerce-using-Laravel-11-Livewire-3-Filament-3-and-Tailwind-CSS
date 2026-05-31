<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDispute extends Model
{
    use HasFactory;

    protected $table = 'payment_disputes';

    protected $fillable = [
        'transaction_id',
        'order_id',
        'gateway_dispute_id',
        'amount',
        'currency',
        'reason',
        'status',
        'evidence',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'evidence' => 'array',
    ];

    public function transaction()
    {
        return $this->belongsTo(PaymentTransaction::class, 'transaction_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
