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
use Illuminate\Support\Facades\Crypt as FacadesCrypt;

class UsersUpdated implements ShouldBroadcast
{
    
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $users)
    {
        Log::info('UpdateUsers event fired');
    }

    public function broadcastOn()
    {
        return new Channel('public.user');
    }

    public function broadcastAs()
    {
        return "users-updated";
    }

    public function broadcastWith() {
        $usersWithDecryptedPasswords = array_map(function($user) {
            $user['password'] = FacadesCrypt::decryptString($user->password);
            return $user;
        }, $this->users);

        return $usersWithDecryptedPasswords;
    }
}
