<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|max:255|confirmed',
            'document' => 'required|cpf_ou_cnpj|unique:users,document',
            'phone' => 'sometimes|celular_com_ddd',
            'username' => 'sometimes|string|max:255|unique:users,username',
            'ref_code' => 'sometimes|string|max:255|unique:users,ref_code',
            'affiliate_id' => 'sometimes'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo de nome é obrigatório.',
            'name.string' => 'O campo de nome deve ser uma string.',
            'name.max' => 'O campo de nome deve ter no máximo :max caracteres.',
            'email.required' => 'O campo de e-mail é obrigatório.',
            'email.email' => 'O campo de e-mail deve ser um e-mail válido.',
            'email.unique' => 'O e-mail informado já está em uso.',
            'email.max' => 'O campo de e-mail deve ter no máximo :max caracteres.',
            'password.required' => 'O campo de senha é obrigatório.',
            'password.string' => 'O campo de senha deve ser uma string.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'password.max' => 'A senha deve ter no máximo :max caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde',
            'document.required' => 'O campo de documento é obrigatório.',
            'document.cpf_ou_cnpj' => 'O campo de documento deve ser um CPF ou CNPJ válido.',
            'document.unique' => 'O documento informado já está em uso.',
            'phone.celular_com_ddd' => 'O campo de telefone deve ser um telefone válido.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $affiliate = $this->ref ? User::where('ref_code', $this->ref)->first() : null;

        $this->merge([
            'ref_code' => Str::upper(Str::random(10)),
            'username' => Str::lower(Str::random()),
            'affiliate_id' => $affiliate ? $affiliate->id : null,
        ]);
    }
}
