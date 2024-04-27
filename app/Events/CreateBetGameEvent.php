<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

class CreateBetGameEvent
{
    use Dispatchable;

    public function __construct(public Model $game)
    {
    }
}
