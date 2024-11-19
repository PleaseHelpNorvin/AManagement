<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\MessageSent;
use App\Models\Message;


class MessageSentListener
{

    protected $messageModel;
    /**
     * Create the event listener.
     */
    public function __construct(Message $messageModel)
    {
        $this->messageModel = $messageModel;
    }

    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        
        $message = $event->message;
        $sender_id = $message->sender_id;
        $receiver_id = $message->receiver_id;
        
        $this->messageModel->create([
            'message' => $message->content,
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
        ]);
        
    }
}
