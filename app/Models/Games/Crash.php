<?php

namespace App\Models\Games;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Crash extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'multiplier',
        'multiplier_crashed',
        'status',
        'pending_at',
        'started_at',
    ];

    protected $casts = [
        'hash' => 'string',
        'multiplier' => 'float',
        'multiplier_crashed' => 'float',
    ];

    protected $hidden = [
        'multiplier_crashed',
        'deleted_at',
    ];



    public function bets()
    {
        return $this->hasMany(CrashBet::class)->orderBy('bet', 'desc');
    }
}
