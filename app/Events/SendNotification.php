<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldBroadcastNow
{
    use InteractsWithSockets, SerializesModels;

    public $data = [];

    /**
     * Create a new event instance.

     *

     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get the channels the event should broadcast on.

     *

     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new Channel('user-channel');
    }

    /**
     * The event's broadcast name.

     *

     * @return string
     */
    public function broadcastAs()
    {

        return 'UserEvent';
    }

    /**
     * The event's broadcast name.

     *

     * @return string
     */
    public function broadcastWith()
    {
        return ['title' => 'This is testing notification', 'content' => 'This is notification content', 'externalLink' => 'This is Link'];
    }
}
