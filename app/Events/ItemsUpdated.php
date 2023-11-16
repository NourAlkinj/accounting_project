<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ItemsUpdated  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

 
    
  
    public function __construct(public $items)
    {
        Log::info('UpdateItems event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.item');
    }

    public function broadcastAs()
    {
        return "items-updated";
    }

    public function broadcastWith() {
        return $this->items;
    }

}
