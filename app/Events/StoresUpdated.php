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

class StoresUpdated implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $stores)
    {
        Log::info('UpdateStores event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.store');
    }

    public function broadcastAs()
    {
        return "stores-updated";
    }

    public function broadcastWith()
    {
        return $this->stores;
    }
}
