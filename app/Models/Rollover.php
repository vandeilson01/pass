<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rollover extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'amount',
        'count',
        'multiplier',
        'rollover_count',
    ];

    public function bonus()
    {
        return $this->belongsTo(Bonus::class);
    }

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }
}
