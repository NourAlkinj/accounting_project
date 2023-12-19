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

class CategoriesGuideUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $categories)
    {
        Log::info('CategorisGuideUpdated event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.categoriesGuide');
    }

    public function broadcastAs()
    {
        return "categories-guide-updated";
    }

    public function broadcastWith() {
        return $this->categories;
    }
}
