<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlaygroundEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   
    public function __construct()
    {
        //
    }

   
    public function broadcastOn()
    {
        return new Channel('public.playground.1');
    }

    public function broadCastAs() {
        return "User Created";
    }
}
