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

class CurrenciesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    

    public function __construct(public $currencies)
    {
        Log::info('UpdateCurrency event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.currency');
    }

    public function broadcastAs()
    {
        return "currencies-updated";
    }

    public function broadcastWith() {
        return $this->currencies;
    }
}
