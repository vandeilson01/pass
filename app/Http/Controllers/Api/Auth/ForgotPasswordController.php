<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserForgotPasswordEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function __invoke(ForgotPasswordRequest $request){
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if(!$user){
            return response()->json([
                'message' => 'E-mail não encontrado.'
            ], 404);
        }

        $token = Str::random(25);

        PasswordResetToken::create([
            'email' => $validated['email'],
            'token' => $token
        ]);

        UserForgotPasswordEvent::dispatch($user, $token);

        return response()->json([
            'message' => 'Enviamos um e-mail com instruções para alterar sua senha.'
        ]);
    }
}
