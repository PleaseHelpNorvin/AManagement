<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\MessageSent;
// use App\Models\Message;
use App\Models\Notification;
use App\Models\User;



class MessageSentListener
{
    use InteractsWithQueue;

    public function handle(MessageSent $event): void
    {
        // Get the sender's name
        $sender = User::find($event->message->sender_id);
        $senderName = $sender ? $sender->name : 'Unknown User';

        // Notify the receiver about the new message
        Notification::create([
            'user_id' => $event->message->receiver_id,
            'content' => "You have a new message from {$senderName}",
        ]);
    }
}
