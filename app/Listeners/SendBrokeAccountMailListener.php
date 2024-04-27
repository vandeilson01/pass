<?php

namespace App\Listeners;

use App\Mail\User\BrokeAccountMail;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendBrokeAccountMailListener implements ShouldQueue
{
    use Queueable;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        $this->onQueue('default' . env('APP_NAME'));
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $game = $event->game;

        $wallet = Wallet::find($game->user->wallet->id);
        if ($wallet->balance <= 0)
        {
            Mail::to($game->user)->send(new BrokeAccountMail($game->user->name));
        }
    }
}
