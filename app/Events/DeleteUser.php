<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteUser implements ShouldBroadcast
{
  use Dispatchable, InteractsWithSockets, SerializesModels;

  public $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function broadcastOn()
  {
    return new Channel('InformationUser.' . $this->user->id);
  }

  public function broadcastWith()
  {
    return [
      'user' => null,
      'isValid' => false,
    ];
  }
}
