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

class VoucherTemplatesUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $voucherTemplates)
    {
        Log::info('UpdateVoucherTemplates event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.voucher-template');
    }

    public function broadcastAs()
    {
        return "voucher-templates-updated";
    }

    public function broadcastWith()
    {
        return $this->voucherTemplates;
    }
}
