<?php

namespace App\Events;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Notification $notification){    }

    public function broadcastOn()
    {
        return new Channel('notifications.' . $this->notification->to_user_id);
    }

    public function broadcastAs()
    {
        return "notification-created";
    }

    public function broadcastWith()
    {
        return [$this->notification];
    }

}
