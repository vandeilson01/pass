<?php

namespace App\Models\Games;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrashBet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'crash_id',
        'bet',
        'balance_type',
        'payout_multiplier',
        'win',
        'fake',
        'user_id',
    ];

    protected $hidden = [
        'fake',
        'deleted_at',
    ];

    protected $casts = [
        'bet' => 'float',
        'payout_multiplier' => 'float',
        'win' => 'boolean',
        'fake' => 'boolean',
    ];

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }

    public function crash()
    {
        return $this->belongsTo(Crash::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
