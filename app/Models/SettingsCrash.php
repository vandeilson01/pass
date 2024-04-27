<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsCrash extends Model
{
    use HasFactory;

    protected $table = 'settings_crash';

    protected $fillable = [
        'fake_bets',
        'fake_bets_min',
        'fake_bets_max',
        'next_crash_value',
        'percent_profit_daily',
        'percent_profit_week',
        'percent_profit_month',
        'crash_timer',
    ];

}
