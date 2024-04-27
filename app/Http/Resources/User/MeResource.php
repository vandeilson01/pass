<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                ...auth()->user()->only([
                    'id',
                    'name',
                    'email',
                    'document',
                    'phone',
                    'birth_date',
                    'avatar',
                    'ref_code'
                ]),
                'roles' => $this->roles->pluck('name'),
                'permissions' => $this->getPermissionsViaRoles()->pluck('name'),
            ],
        ];
    }
}
