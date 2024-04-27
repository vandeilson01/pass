<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bonus extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'hash',
        'status',
        'balance',
        'credit_hold',
        'expiration_at',
        'user_id',
    ];

    protected $casts = [
        'expiration_at' => 'datetime',
    ];

    public function rollover()
    {
        return $this->hasOne(Rollover::class);
    }

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }

}
