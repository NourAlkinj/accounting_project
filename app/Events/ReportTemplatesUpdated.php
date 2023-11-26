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


class ReportTemplatesUpdated implements ShouldBroadcast
{

  use Dispatchable, InteractsWithSockets, SerializesModels;

  public function __construct(public $report_templates)
  {
    Log::info('UpdateReportTemplates event fired');
  }


  public function broadcastOn()
  {
    return new PrivateChannel('public.report_templates');
  }


  public function broadcastAs()
  {
    return "report_templates-updated";
  }

  public function broadcastWith()
  {
    return $this->report_templates;
  }
}