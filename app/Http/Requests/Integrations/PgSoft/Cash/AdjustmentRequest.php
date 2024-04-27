<?php

namespace App\Http\Requests\Integrations\PgSoft\Cash;

use Illuminate\Foundation\Http\FormRequest;

class AdjustmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'operator_token' => 'required|string',
            'secret_key' => 'required|string',
            'player_name' => 'required|string',
            'currency_code' => 'required|string',
            'transfer_amount' => 'required|decimal:2',
            'adjustment_id' => 'required|integer',
            'adjustment_transaction_id' => 'required|string|max:200',
            'adjustment_timestamp' => 'required|integer',
            'transaction_type' => 'required|string|in:115,900,901', //criar um enum para isso 115: Promotion, 900: External Adjustment, 901: Tournament Adjustment
            'bet_type' => 'required|integer',
            'promotion_id' => 'sometimes|integer',
            'promotion_type' => 'sometimes|integer|in:1,2,3', //1: Money Rain, 2: Money Rain Daily Bonus, 3: Daily Cashpot
            'remark' => 'sometimes|string',
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
            'player_name.required' => 'player_name is required',
            'player_name.string' => 'player_name must be a string',
            'currency_code.required' => 'currency_code is required',
            'currency_code.string' => 'currency_code must be a string',
            'transfer_amount.required' => 'transfer_amount is required',
            'transfer_amount.decimal' => 'transfer_amount must be a decimal',
            'adjustment_id.required' => 'adjustment_id is required',
            'adjustment_id.integer' => 'adjustment_id must be an integer',
            'adjustment_transaction_id.required' => 'adjustment_transaction_id is required',
            'adjustment_transaction_id.string' => 'adjustment_transaction_id must be a string',
            'adjustment_transaction_id.max' => 'adjustment_transaction_id must be a string with a maximum length of 200',
            'adjustment_timestamp.required' => 'adjustment_timestamp is required',
            'adjustment_timestamp.integer' => 'adjustment_timestamp must be an integer',
            'transaction_type.required' => 'transaction_type is required',
            'transaction_type.string' => 'transaction_type must be a string',
            'transaction_type.in' => 'transaction_type must be one of the following types: 115, 900, 901',
            'bet_type.required' => 'bet_type is required',
            'bet_type.integer' => 'bet_type must be an integer',
            'promotion_id.integer' => 'promotion_id must be an integer',
            'promotion_type.integer' => 'promotion_type must be an integer',
            'promotion_type.in' => 'promotion_type must be one of the following types: 1, 2',
            'remark.string' => 'remark must be a string',
        ];
    }
}
