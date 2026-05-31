<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentFailed
{
    use Dispatchable, SerializesModels;

    public Order $order;
    public string $errorMessage;

    public function __construct(Order $order, string $errorMessage)
    {
        $this->order = $order;
        $this->errorMessage = $errorMessage;
    }
}
