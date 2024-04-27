<?php

namespace App\Http\Requests\Admin\Configs\Games\Double;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoubleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fake_bets' => 'required|boolean',
            'fake_bets_min' => 'required|integer|min:1|max:100',
            'fake_bets_max' => 'required|integer|min:1|max:999',
            'next_double_value' => 'sometimes|nullable|integer|min:0|max:14',
            'next_double_color' => 'sometimes|nullable|in:white,green,black',
            'percent_profit_daily' => 'required|integer|min:1|max:100',
            'percent_profit_week' => 'required|integer|min:1|max:100',
            'percent_profit_month' => 'required|integer|min:1|max:100',
            'double_timer' => 'required|integer|min:1|max:60',
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

}
