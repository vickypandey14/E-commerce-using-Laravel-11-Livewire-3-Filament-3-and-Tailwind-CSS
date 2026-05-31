<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentRefund extends Model
{
    use HasFactory;

    protected $table = 'payment_refunds';

    protected $fillable = [
        'transaction_id',
        'order_id',
        'gateway_refund_id',
        'amount',
        'reason',
        'status',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
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
