<?php

namespace App\Http\Controllers\Api\Games\Crash;

use App\Http\Controllers\Controller;
use App\Jobs\Games\Crash\CreateFakeBetCrashJob;

class CreateFakeBetsController extends Controller
{
    public function __invoke()
    {
        CreateFakeBetCrashJob::dispatch();

        return response()->json([
            'message' => 'Its impossible to create fake bets in production environment.'
        ]);
    }
}
