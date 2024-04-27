<?php

namespace App\Http\Controllers\Api\Games\Crash;

use App\Http\Controllers\Controller;
use App\Jobs\Games\Crash\CreateFakeCashoutCrashJob;

class CreateFakeCashoutsController extends Controller
{
    public function __invoke()
    {
        CreateFakeCashoutCrashJob::dispatch();

        return response()->json([
            'message' => 'Its impossible to create fake cashouts in production environment.'
        ]);
    }
}
