<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $doctor;
    public function __construct($doctor)
    {
        $this->doctor = $doctor;
        $this->dontBroadcastToCurrentUser();
    }

    public function broadcastOn(){
        return new Channel('NotificationChannel');
    }

    public function broadcastAs(){
        return "EchoEvent";
    }
}
