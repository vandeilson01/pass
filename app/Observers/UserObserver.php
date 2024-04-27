<?php

namespace App\Observers;

use App\Events\UserRegisteredEvent;
use App\Models\User;

class UserObserver
{

    public function created(User $user)
    {

        if($user->is_fake){
            $user->assignRole('fake');
        }else{
            UserRegisteredEvent::dispatch($user);
            $user->assignRole('player');
        }

    }

}
