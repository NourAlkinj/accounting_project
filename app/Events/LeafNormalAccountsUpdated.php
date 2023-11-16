<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeafNormalAccountsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(public $leafNormalAccounts)
    {
        //
    }


    public function broadcastOn()
    {
        return new Channel('public.item');
    }

    public function broadcastAs()
    {
        return "leaf-normal-accounts-updated";
    }

    public function broadcastWith() {
        return $this->leafNormalAccounts;
    }
}
