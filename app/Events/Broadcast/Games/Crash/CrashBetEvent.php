<?php

namespace App\Events\Broadcast\Games\Crash;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CrashBetEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $message)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('crash')
        ];
    }

    public function broadcastAs(): string
    {
        return 'crash-bet';
    }
}
