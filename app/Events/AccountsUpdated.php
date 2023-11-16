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


class AccountsUpdated implements ShouldBroadcast
{
 
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $accounts)
    {
        Log::info('UpdateAccount event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.account');
    }

    public function broadcastAs()
    {
        return "accounts-updated";
    }

    public function broadcastWith() {
        return $this->accounts;
    }

}
