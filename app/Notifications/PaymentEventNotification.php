<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentEventNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected string $type;
    protected array $data;

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = new MailMessage();

        if ($this->type === 'received') {
            $mail->subject('Payment Received: Order #' . $this->data['order_id'])
                 ->greeting('Hello ' . $notifiable->name . '!')
                 ->line('Thank you for your purchase. We have received your payment of ' . $this->data['amount'] . ' ' . $this->data['currency'] . '.')
                 ->line('Your order status has been updated to processing.')
                 ->action('View Order Details', route('my-order-details', ['order' => $this->data['order_id']]))
                 ->line('Thank you for shopping with us!');
        } elseif ($this->type === 'failed') {
            $mail->subject('Payment Failed: Order #' . $this->data['order_id'])
                 ->error()
                 ->greeting('Hello ' . $notifiable->name . '!')
                 ->line('We were unable to process your payment for Order #' . $this->data['order_id'] . '.')
                 ->line('Reason for failure: ' . ($this->data['error'] ?? 'Unknown error'))
                 ->action('Retry Checkout', route('checkout'))
                 ->line('Please update your payment credentials or try a different payment method.');
        } elseif ($this->type === 'refunded') {
            $mail->subject('Refund Processed: Order #' . $this->data['order_id'])
                 ->greeting('Hello ' . $notifiable->name . '!')
                 ->line('We have processed a refund of ' . $this->data['amount'] . ' INR for your Order #' . $this->data['order_id'] . '.')
                 ->line('Reason: ' . ($this->data['reason'] ?? 'Not specified'))
                 ->line('The amount will be credited back to your original payment method in 5-7 business days.');
        }

        return $mail;
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'order_id' => $this->data['order_id'],
            'amount' => $this->data['amount'],
            'message' => $this->type === 'received' 
                ? "Payment received for Order #{$this->data['order_id']}"
                : ($this->type === 'refunded' ? "Refund processed for Order #{$this->data['order_id']}" : "Payment failed for Order #{$this->data['order_id']}"),
        ];
    }
}
