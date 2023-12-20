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

class BillTemplateUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $bill_templates)
    {
        Log::info('UpdateBillTemplate event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.bill_template');
    }

    public function broadcastAs()
    {
        return "bill_templates-updated";
    }

    public function broadcastWith() {
        return $this->bill_templates;
    }
}
