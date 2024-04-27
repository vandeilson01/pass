<?php

namespace App\Models\Games;

use App\Models\Transaction;
use App\Models\User;
use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Mines extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'bet',
        'balance_type',
        'number_of_bombs',
        'bombs',
        'clicks',
        'finish',
        'win',
        'user_id',
        'payout_multiplier',
        'payout_multiplier_on_next'
    ];

    protected $casts = [
        'bombs' => 'json',
        'clicks' => 'json',
    ];

    protected $hidden = [
        'bombs',
        'deleted_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }
}
