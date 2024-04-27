<?php

namespace App\Listeners;

use App\Mail\Game\PlayGameMail;
use App\Models\Games\CrashBet;
use App\Models\Games\DoubleBet;
use App\Models\Games\Mines;
use App\Models\GamesBet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendPlayGameEmailListener implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('default' . env('APP_NAME'));
    }

    public function handle($event): void
    {
        /*
        $bet = $event->bet;
        $firstOfTheDay = false;

        if ($bet instanceof GamesBet){
            $gameName = $bet->game ? $bet->game->name : "Cassino";
            $firstOfTheDay = GamesBet::where('user_id', $bet->user_id)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->count() == 1;
        }else if ($bet instanceof CrashBet){
            $gameName = "Crash";
            $firstOfTheDay = CrashBet::where('user_id', $bet->user_id)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->count() == 1;
        }else if ($bet instanceof DoubleBet){
            $gameName = "Double";
            $firstOfTheDay = DoubleBet::where('user_id', $bet->user_id)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->count() == 1;
        }else if ($bet instanceof Mines){
            $gameName = "Mines";
            $firstOfTheDay = Mines::where('user_id', $bet->user_id)
                            ->whereDate('created_at', date('Y-m-d'))
                            ->count() == 1;
        }

        if ($firstOfTheDay)
        {
            Mail::to($bet->user)->send(new PlayGameMail($bet, $gameName));
        }*/
    }
}
