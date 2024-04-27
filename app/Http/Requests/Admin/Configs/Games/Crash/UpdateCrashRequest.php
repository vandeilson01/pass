<?php

namespace App\Http\Requests\Admin\Configs\Games\Crash;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCrashRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'fake_bets' => 'required|boolean',
            'fake_bets_min' => 'required|integer|min:1|max:100',
            'fake_bets_max' => 'required|integer|min:1|max:999',
            'next_crash_value' => 'sometimes|nullable|decimal:2',
            'percent_profit_daily' => 'required|integer|min:1|max:100',
            'percent_profit_week' => 'required|integer|min:1|max:100',
            'percent_profit_month' => 'required|integer|min:1|max:100',
            'crash_timer' => 'required|integer|min:1|max:60',
        ];
    }

    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

}
