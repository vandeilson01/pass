<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingsDouble extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fake_bets',
        'fake_bets_min',
        'fake_bets_max',
        'next_double_value',
        'next_double_color',
        'percent_profit_daily',
        'percent_profit_week',
        'percent_profit_month',
        'double_timer',
    ];
}
