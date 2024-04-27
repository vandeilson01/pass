<?php

namespace App\Listeners;

use App\Mail\User\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailListener implements ShouldQueue
{

    use Queueable;

    public function __construct()
    {
        $this->onQueue('default' . env('APP_NAME'));
    }

    public function handle($event): void
    {
        $user = $event->user;

        if ($user->is_fake) {
            return;
        }

        Mail::to($user)
            ->send(new WelcomeMail($user));
    }
}
