<?php

namespace App\Http\Resources\Admin\Games\Providers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameProvidersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->image,
            'fields' => $this->fields,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
