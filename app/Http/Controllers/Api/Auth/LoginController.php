<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User\LoginResource;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request){
        
        $validated = $request->validated();

        if(!auth()->attempt($validated)){
            return response()->json([
                'message' => 'Credenciais inválidas!'
            ], 401);
        }

        auth()->user()->ip = $request->ip();
        auth()->user()->save();

        return response()->json(new LoginResource(auth()->user()));
    }
}
