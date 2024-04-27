<?php

namespace App\Listeners;

use App\Mail\Cashout\ApproveCashoutMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCreateCashoutEmailListener implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('default' . env('APP_NAME'));
    }

    public function handle($event): void
    {
        $cashout = $event->cashout;

        Mail::to($cashout->user)->send(new ApproveCashoutMail($cashout));
    }
}
