<?php

namespace App\Events;

use App\Models\GamesBet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

class CreatePgGameEvent
{
    use Dispatchable;

    public function __construct(public GamesBet $game)
    {
    }
}
