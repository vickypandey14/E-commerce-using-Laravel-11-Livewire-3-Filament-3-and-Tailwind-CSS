<?php

namespace App\Events;

use App\Models\PaymentRefund;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RefundProcessed
{
    use Dispatchable, SerializesModels;

    public PaymentRefund $refund;

    public function __construct(PaymentRefund $refund)
    {
        $this->refund = $refund;
    }
}
