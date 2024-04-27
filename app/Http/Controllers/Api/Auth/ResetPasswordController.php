<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Models\PasswordResetToken;
use App\Models\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function __invoke(ResetPasswordRequest $request){
        $validated = $request->validated();

        $token = PasswordResetToken::where('token', $validated['token'])->first();

        if (!$token or !Carbon::now()->subMinutes(env('RESET_PASSWORD_EXPIRED_IN_MINUTES'))->lt($token->created_at)) {
            return response()->json(['message' => 'Token está Inválido ou Expirado!'], 422);
        }

        $user = User::where('email', $token->email)->first();

        if(!$user){
            return response()->json(['message' => 'Token está Inválido ou Expirado!'], 422);
        }

        $user->password = $validated['password'];
        $user->save();

        PasswordResetToken::where('email', $user->email)->delete();

        return response()->json([
            'message' => 'Senha alterada com sucesso'
        ]);
    }
}
