<?php

namespace App\Http\Controllers\Api\Games\Integrations\BetSac;

use App\Http\Controllers\Controller;
use App\Http\Requests\Integrations\BetSac\WebhookRequest;
use App\Models\GamesBet;
use App\Models\SessionGame;
use App\Models\User;

class WebhookController extends Controller
{
    public function __invoke(WebhookRequest $request)
    {
        switch ($request->action){
            case "getBalance":
                return $this->getPlayerBalance($request->session, $request->player_id);
            case "bet":
                return $this->setBet($request->session, $request->transaction_id, $request->amount);
            case "win":
                return $this->winBet($request->session, $request->transaction_id, $request->amount);
            case "refound":
                return $this->refoundBet($request->session, $request->transaction_id, $request->amount);
        }
    }

    private function getPlayerBalance(string $session, int $playerId)
    {
        $user = User::where('id', $playerId)->first();

        if (empty($user)) {
            return response()->json(['action' => 'getBalance', 'message' => 'Player does not exist', 'status' => 401], 401);
        }

        $sessionExists = SessionGame::where('session', $session)->where('user_id')->exists();
        if (!$sessionExists){
            SessionGame::create([
                'session' => $session,
                'user_id' => $playerId
            ]);
        }

        return response()->json([
            'action' => 'getBalance',
            'balance' => (int)$user->wallet->balance
        ]);
    }

    private function setBet(string $session, string $transactionId, int $amount)
    {
        $session = SessionGame::where('session', $session)->first();
        if (empty($session)) {
            return response()->json(['action' => 'bet', 'message' => 'Session does not exist', 'status' => 401], 401);
        }

        $user = User::findOrFail($session->user_id);

        if ($amount > 0) {
            $balance = $user->wallet->balance;
            if ($amount > $balance) {
                return response()->json(['action' => 'bet', 'message' => 'Insufficient balance', 'status' => 401], 401);
            }
        }

        if (empty($user)) {
            return response()->json(['action' => 'bet', 'message' => 'Player does not exist', 'status' => 401], 401);
        }

        if (empty($user->wallet)) {
            return response()->json(['action' => 'bet', 'message' => 'Player wallet does not exist', 'status' => 401], 401);
        }

        GamesBet::query()->firstOrCreate(
            [
                'user_id' => $user->id,
                'parent_bet_id' => "N/A",
                'bet_id' => $transactionId,
                'game_id' => null,
            ],
            [
                'bet' => $amount > 0 ? $amount : max($amount, 0),
                'balance_type' => 'wallet',
                'win' => 0,
                'payout_multiplier' => -1,
            ]
        );

        return response()->json(['action' => 'bet', 'status' => 200]);
    }

    private function winBet(string $session, string $transactionId, int $amount)
    {
        $session = SessionGame::where('session', $session)->first();
        if (empty($session)) {
            return response()->json(['action' => 'win', 'message' => 'Session does not exist', 'status' => 401], 401);
        }
        //amount = 0 is loss and bet already created as a debit, so ignore nad return 200
        //if amount > 0, we generate the credit bet
        if ($amount > 0){
            $bet = GamesBet::where('bet_id', $transactionId)->orderBy('id', 'asc')->first();

            $betAmount = $bet->bet;

            $payoutMultiplier = $amount / $betAmount;

            GamesBet::create(
                [
                    'user_id' => $bet->user_id,
                    'parent_bet_id' => $transactionId,
                    'bet_id' => $transactionId."-win",
                    'game_id' => $bet->game_id,
                    'bet' => $betAmount,
                    'balance_type' => 'wallet',
                    'win' => 1,
                    'payout_multiplier' => $payoutMultiplier,
                ]
            );
        }

        return response()->json(["action" => "win", 'status' => 200]);
    }

    private function refoundBet(string $session, string $transactionId, int $amount)
    {
        $session = SessionGame::where('session', $session)->first();
        if (empty($session)) {
            return response()->json(['action' => 'win', 'message' => 'Session does not exist', 'status' => 401], 401);
        }

        if ($amount > 0){
            $bet = GamesBet::where('bet_id', $transactionId)->orderBy('id', 'asc')->first();

            $betAmount = $bet->bet;

            GamesBet::create(
                [
                    'user_id' => $bet->user_id,
                    'parent_bet_id' => $transactionId,
                    'bet_id' => $transactionId."-refound",
                    'game_id' => $bet->game_id,
                    'bet' => $betAmount,
                    'balance_type' => 'wallet',
                    'win' => 1,
                    'payout_multiplier' => 1,
                ]
            );
        }

        return response()->json(["action" => "refound", 'status' => 200]);
    }
}
