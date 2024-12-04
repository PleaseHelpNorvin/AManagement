<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentDueNotification extends Notification
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail']; // You can also add 'database', 'sms', etc. if needed
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Payment Due Notification')
                    ->line($this->message)
                    ->action('View Contract', url('/contracts/'.$notifiable->contract_code))
                    ->line('Thank you for your attention!');
    }

    // If you want to store this notification in the database as well
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'contract_code' => $notifiable->contract_code,
        ];
    }
}
