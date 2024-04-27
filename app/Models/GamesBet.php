<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GamesBet extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
        'bet',
        'win',
        'fake',
        'payout_multiplier',
        'balance_type',
        'parent_bet_id',
        'bet_id'
    ];

    protected static function boot()
    {
        parent::boot();

        GamesBet::creating(function ($model) {
            $model->hash = Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }

    public function game()
    {
        return $this->belongsTo(Games::class, 'game_id');
    }
}
