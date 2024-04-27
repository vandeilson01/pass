<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'balance',
        'name',
        'type',
        'min_cashout_amount',
        'max_cashout_amount',
        'user_id'
    ];

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }
}
