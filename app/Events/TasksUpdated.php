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

class TasksUpdated implements ShouldBroadcast
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $tasks)
    {
        Log::info('Update Tasks Event Fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.task');
    }

    public function broadcastAs()
    {
        return "tasks-updated";
    }

    public function broadcastWith()
    {
        return $this->tasks;
    }
}
