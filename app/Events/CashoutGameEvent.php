<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;

class CashoutGameEvent
{
    use Dispatchable;

    public function __construct(public Model $game)
    {
    }
}
