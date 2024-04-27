<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\UserRegisteredEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\RegisterResource;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $validated = $request->validated();
        $validated['ip'] = $request->ip();

        $validated['pix_key'] = $validated['document'];
        $validated['pix_key_type'] = 'cpf';

        $user = User::create($validated);

        if (!$user) {
            return response()->json([
                'message' => 'Erro ao criar usuário.'
            ], 500);
        }

        auth()->login($user);

        return response()->json(new RegisterResource(auth()->user()), 201);
    }
}
