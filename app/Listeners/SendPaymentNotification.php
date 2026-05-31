<?php

namespace App\Listeners;

use App\Events\PaymentReceived;
use App\Events\PaymentFailed;
use App\Events\RefundProcessed;
use App\Notifications\PaymentEventNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendPaymentNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle payment received event.
     */
    public function handlePaymentReceived(PaymentReceived $event): void
    {
        $order = $event->order;
        $user = $order->user;

        if ($user) {
            $user->notify(new PaymentEventNotification('received', [
                'order_id' => $order->id,
                'amount' => $order->grand_total,
                'currency' => $order->currency ?? 'INR',
            ]));
        }
    }

    /**
     * Handle payment failed event.
     */
    public function handlePaymentFailed(PaymentFailed $event): void
    {
        $order = $event->order;
        $user = $order->user;

        if ($user) {
            $user->notify(new PaymentEventNotification('failed', [
                'order_id' => $order->id,
                'amount' => $order->grand_total,
                'error' => $event->errorMessage,
            ]));
        }
    }

    /**
     * Handle refund processed event.
     */
    public function handleRefundProcessed(RefundProcessed $event): void
    {
        $refund = $event->refund;
        $order = $refund->order;
        $user = $order?->user;

        if ($user) {
            $user->notify(new PaymentEventNotification('refunded', [
                'order_id' => $order->id,
                'amount' => $refund->amount,
                'reason' => $refund->reason,
            ]));
        }
    }

    /**
     * Generic handler mapping for Laravel.
     */
    public function subscribe($events): array
    {
        return [
            PaymentReceived::class => 'handlePaymentReceived',
            PaymentFailed::class => 'handlePaymentFailed',
            RefundProcessed::class => 'handleRefundProcessed',
        ];
    }
}
