<?php

namespace App\Models\Payment;

use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cashout extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'status',
        'external_id',
        'amount',
        'pix_key',
        'pix_key_type',
        'user_id',
        'wallet_id',
        'gateway_id',
        'observation',
        'approved_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }
}
