<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\Account\GetProfileResource;

class GetProfileController extends Controller
{
    public function __invoke()
    {
        return response()->json(new GetProfileResource(auth()->user()));
    }
}
