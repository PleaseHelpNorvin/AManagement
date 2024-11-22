<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $message;
    public $userID;
    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
        $this->userID = $message->receiver_id;
        
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */

    public function broadcastWith(): array
    {
        return [
            'message' => $this->message->message, // Updated to match the migration
            'sender_id' => $this->message->sender_id,
            'receiver_id' => $this->message->receiver_id,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('private-channel.user.' . $this->userID),  // Broadcasting to the receiver's private channel
        ];
    }
}
