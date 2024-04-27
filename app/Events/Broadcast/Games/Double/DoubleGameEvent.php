<?php

namespace App\Events\Broadcast\Games\Double;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DoubleGameEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public $message)
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('double')
        ];
    }

    public function broadcastAs(): string
    {
        return 'double-game';
    }
}
