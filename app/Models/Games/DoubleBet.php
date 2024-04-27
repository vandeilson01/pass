<?php

namespace App\Models\Games;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DoubleBet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'double_id',
        'bet',
        'balance_type',
        'bet_color',
        'payout_multiplier',
        'win',
        'fake',
        'user_id',
    ];

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }

    public function double()
    {
        return $this->belongsTo(Double::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
