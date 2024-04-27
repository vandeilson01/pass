<?php

namespace App\Http\Requests\Admin\Configs\Gateways;

use App\Rules\ValidateActiveGatewayRule;
use App\Rules\ValidateRequiredCredentialsFieldsRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGatewayConfigRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'gateway_id' => ['required', 'exists:gateways,id'],
            'credentials' => ['required', new ValidateRequiredCredentialsFieldsRule($this->gateway_id)],
            'is_active' => ['boolean', new ValidateActiveGatewayRule($this->gateway_id)],
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public function messages(): array
    {
        return [
            'gateway_id.required' => 'O campo gateway_id é obrigatório',
            'gateway_id.exists' => 'O campo gateway_id deve ser um id válido',
            'credentials.required' => 'O campo credentials é obrigatório',
            'credentials.array' => 'O campo credentials deve ser um array',
            'credentials.*.required' => 'O campo credentials deve ser um array',
        ];
    }
}
