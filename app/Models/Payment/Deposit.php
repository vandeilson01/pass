<?php

namespace App\Models\Payment;

use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'status',
        'amount',
        'external_id',
        'currency',
        'has_bonus',
        'pix_url',
        'pix_qr_code',
        'refused_reason',
        'user_id',
        'wallet_id',
        'gateway_id',
        'created_by',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function transaction()
    {
        return $this->morphMany(Transaction::class, 'typable');
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }

    public function canBeCanceled(): bool
    {
        return $this->status === 'pending';
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
