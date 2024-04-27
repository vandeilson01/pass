<?php

namespace App\Http\Resources\Account;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'name' => $this->name,
                'email' => $this->email,
                'document' => $this->document,
                'phone' => $this->phone,
                'birth_date' => $this->birth_date,
                'pix_key' => $this->pix_key,
                'pix_key_type' =>$this->pix_key_type,
            ],
        ];
    }
}
