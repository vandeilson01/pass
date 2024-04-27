<?php

namespace App\Http\Requests\Admin\Games\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateAvailableGamesProviderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'slug' => ['required', 'string'],
            'fields' => ['required', 'array'],
            'image' => ['sometimes', 'string', 'mimes:jpeg,jpg,png'],
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'name.string' => 'O campo nome deve ser uma string',
            'slug.required' => 'O campo slug é obrigatório',
            'slug.string' => 'O campo slug deve ser uma string',
            'fields.required' => 'O campo fields é obrigatório',
            'fields.array' => 'O campo fields deve ser um array',
            'image.string' => 'O campo image deve ser uma string',
            'image.mimes' => 'O campo image deve ser uma imagem',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name)
        ]);
    }
}
