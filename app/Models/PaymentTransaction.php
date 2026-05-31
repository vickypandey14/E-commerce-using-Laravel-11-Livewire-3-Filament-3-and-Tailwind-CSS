<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $table = 'payment_transactions';

    protected $fillable = [
        'order_id',
        'user_id',
        'gateway_code',
        'gateway_transaction_id',
        'amount',
        'currency',
        'status',
        'type',
        'error_message',
        'payload',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payload' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function refunds()
    {
        return $this->hasMany(PaymentRefund::class, 'transaction_id');
    }

    public function disputes()
    {
        return $this->hasMany(PaymentDispute::class, 'transaction_id');
    }
}
