<?php

namespace App\Events;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Events\Dispatchable;

class UserRegisteredEvent
{
    use Dispatchable;

    public function __construct(
        public User $user
    )
    {
    }
}
