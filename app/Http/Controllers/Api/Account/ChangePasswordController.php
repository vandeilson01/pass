<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ChangePasswordRequest;

class ChangePasswordController extends Controller
{
    public function __invoke(ChangePasswordRequest $request)
    {
        $user = auth()->user();

        if (!\Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'Senha atual não confere',
            ], 422);
        }

        $user->password = $request->password;
        $user->save();

        return response()->json([
            'message' => 'Senha alterada com sucesso',
        ]);
    }
}
