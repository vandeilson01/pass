<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\MeResource;
use Illuminate\Http\Request;

class MeController extends Controller
{
    public function __invoke(Request $request){
        return response()->json(new MeResource(auth()->user()));
    }
}
