<?php

namespace App\Http\Requests\Integrations\BetSac;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class WebhookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'action' => 'required|string',
            'session' => 'required|string',
            'transaction_id' => 'sometimes|string',
            'amount' => 'sometimes|integer',
            'player_id' => 'sometimes|integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'action.required' => 'Field action is required',
            'action.string' => 'Field action must be a string',
            'session.required' => 'Field session is required',
            'session.string' => 'Field session must be a string',
            'transaction_id.integer' => 'Field transaction_id must be a string',
            'amount.integer' => 'Field amount must be a string',
            'player_id.integer' => 'Field player_id must be a integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'error' => 'Unauthorized',
            'message' => $validator->errors()->first(), // Pode personalizar a mensagem de erro conforme necessário
            'status' => 401,
        ], 401);

        throw new ValidationException($validator, $response);
    }
}
