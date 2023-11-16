<?php


namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class CostCentersUpdated implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $costCenters)
      {
          Log::info('UpdateCostCenters event fired');
      }

    public function broadcastOn()
      {
        return new Channel('public.cost-center');
      }

    public function broadcastAs()
    {
      return "cost-centers-updated";
    }

    public function broadcastWith() {
      return $this->costCenters;
    }
}
