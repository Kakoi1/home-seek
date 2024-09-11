<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class FetchMessEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    /**
     *  @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     * @return Channel
     *
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('fetch.' . $this->data['chat_id'] . '.' . $this->data['type']),
        ];
    }

    public function broadcastAs()
    {
        return 'test.message';
    }

    public function broadcastWith(): array
    {
        return $this->data;
    }
}
