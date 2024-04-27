<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Http\Resources\Account\GetProfileResource;

class UpdateProfileController extends Controller
{
    public function __invoke(UpdateProfileRequest $request)
    {
        $validated = $request->validated();
        $user = auth()->user();
        $user->update($validated);

        if(isset($validated['document']) && $user->pix_key_type === 'cpf'){
            $user->pix_key = $validated['document'];
            $user->save();
        }

        return response()->json([
            'message' => 'Informações atualizadas com sucesso',
            'user' => new GetProfileResource($user)
        ]);
    }
}
