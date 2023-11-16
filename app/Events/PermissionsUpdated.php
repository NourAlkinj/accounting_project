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

class PermissionsUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

  public $user;
  public $permissions;

  public function __construct(User $user, $permissions)
  {
    $this->user = $user;
    $this->permissions = $permissions;
  }

  public function broadcastOn()
  {
    return new PrivateChannel('user.' . $this->user->id);
  }
}
