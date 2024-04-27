<?php

namespace App\Listeners;

use App\Mail\User\PasswordResetMail;
use App\Mail\User\WelcomeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendForgotEmailListener implements ShouldQueue
{

    use Queueable;

    public function __construct()
    {
        $this->onQueue('default' . env('APP_NAME'));
    }

    public function handle($event): void
    {
        $user = $event->user;
        $token = $event->token;

        Mail::to($user)->send(new PasswordResetMail($user, $token));
    }
}
