<?php

namespace App\Http\Requests\Integrations\PgSoft;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class VerifySessionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'operator_token' => 'required|string',
            'secret_key' => 'required|string',
            'trace_id' => 'required',
            'operator_player_session' => 'required|string',
            'game_id' => 'sometimes|integer',
            'ip' => 'sometimes|ip',
            'custom_parameters' => 'sometimes|string',
            'bet_type' => 'required|integer',
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
            'operator_player_session.required' => 'operator_player_session is required',
            'operator_player_session.string' => 'operator_player_session must be a string',
            'game_id.integer' => 'game_id must be an integer',
            'ip.ip' => 'ip must be an ip',
            'custom_parameters.string' => 'custom_parameters must be a string',
            'bet_type.required' => 'bet_type is required',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new Response([
            'error' => [
                'code' => 1034,
                'message' => 'Invalid request',
            ],
        ], 400);

        throw new ValidationException($validator, $response);
    }
}
