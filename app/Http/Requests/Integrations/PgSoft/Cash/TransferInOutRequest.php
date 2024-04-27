<?php

namespace App\Http\Requests\Integrations\PgSoft\Cash;

use Illuminate\Foundation\Http\FormRequest;

class TransferInOutRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'operator_token' => 'required|string',
            'secret_key' => 'required|string',
            'trace_id' => 'required',
            'operator_player_session' => 'sometimes|string',
            'player_name' => 'required|string',
            'game_id' => 'required|integer',
            'parent_bet_id' => 'required|integer',
            'bet_id' => 'required|integer',
            'currency_code' => 'required|string',
            'bet_amount' => 'required|decimal:2',
            'win_amount' => 'required|decimal:2',
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
            'operator_player_session.string' => 'operator_player_session must be a string',
            'player_name.required' => 'player_name is required',
            'player_name.string' => 'player_name must be a string',
            'game_id.required' => 'game_id is required',
            'game_id.integer' => 'game_id must be an integer',
            'parent_bet_id.required' => 'parent_bet_id is required',
            'parent_bet_id.integer' => 'parent_bet_id must be an integer',
            'bet_id.required' => 'bet_id is required',
            'bet_id.integer' => 'bet_id must be an integer',
            'currency_code.required' => 'currency_code is required',
            'currency_code.string' => 'currency_code must be a string',
            'bet_amount.required' => 'bet_amount is required',
            'bet_amount.decimal' => 'bet_amount must be a decimal with 2 digits',
            'win_amount.required' => 'win_amount is required',
            'win_amount.decimal' => 'win_amount must be a decimal with 2 digits',
        ];
    }
}
