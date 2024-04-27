<?php

namespace App\Http\Requests\Integrations\PgSoft\Cash;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class GetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'operator_token' => 'required|string',
            'secret_key' => 'required|string',
            'trace_id' => 'required',
            'player_name' => 'required|string',
            'operator_player_session' => 'sometimes|string',
            'game_id' => 'sometimes|integer',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'operator_token.required' => 'operator_token is required',
            'operator_token.string' => 'operator_token must be a string',
            'secret_key.required' => 'secret_key is required',
            'secret_key.string' => 'secret_key must be a string',
            'trace_id.required' => 'trace_id is required',
            'trace_id.uuid' => 'trace_id must be a uuid',
            'player_name.required' => 'player_name is required',
            'player_name.string' => 'player_name must be a string',
            'operator_player_session.string' => 'operator_player_session must be a string',
            'game_id.integer' => 'game_id must be an integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'error' => [
                'code' => '1034',
                'message' => 'Invalid request',
            ],
        ], 400);

        throw new ValidationException($validator, $response);
    }
}
