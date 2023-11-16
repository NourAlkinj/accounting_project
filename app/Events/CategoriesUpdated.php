<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CategoriesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $categories)
    {
        Log::info('UpdateCategory event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.category');
    }

    public function broadcastAs()
    {
        return "categories-updated";
    }

    public function broadcastWith() {
        return $this->categories;
    }
}
