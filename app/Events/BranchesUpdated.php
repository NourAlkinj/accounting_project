<?php

namespace App\Events;

use App\Models\Branch;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BranchesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $branches)
    {
        Log::info('UpdateBranch event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.branch');
    }

    public function broadcastAs()
    {
        return "branches-updated";
    }

    public function broadcastWith() {
        return $this->branches;
    }
}
