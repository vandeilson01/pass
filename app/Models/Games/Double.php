<?php

namespace App\Models\Games;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Double extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'winning_number',
        'winning_color',
        'status',
        'pending_at',
        'started_at',
    ];

    protected $hidden = [
        'winning_number',
        'wining_color',
        'deleted_at',
    ];

    public function bets()
    {
        return $this->hasMany(DoubleBet::class)->orderBy('bet', 'desc');
    }
}
