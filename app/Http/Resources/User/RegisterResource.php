<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => [
                ...auth()->user()->only(['id', 'name', 'email', 'document', 'phone', 'avatar', 'ref_code']),
                'roles' => $this->roles->pluck('name'),
                'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
            ],
        ];
    }
}
