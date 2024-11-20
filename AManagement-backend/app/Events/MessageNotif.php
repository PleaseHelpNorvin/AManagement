<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageNotif implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $userID;
    /**
     * Create a new event instance.
     */
    public function __construct($data, $userID)
    {
        //
        $this->data = $data;
        $this->userID = $userID;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->data,
        ];
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('private-channel.user.' . $this->userID),  // Broadcasting to a specific user's private channel
        ];
    }
}
