<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hash',
        'name',
        'status',
        'type',
        'amount',
        'wallet_id',
        'bonus_id',
        'user_id',
        'typable_id',
        'typable_type',
        'base_type',
    ];

    protected static function boot()
    {
        parent::boot();

        Transaction::creating(function ($model) {
            $model->base_type = class_basename($model->typable_type);
        });
    }

    public function setBaseTypeAttribute($value): void
    {
        $this->attributes['base_type'] = class_basename($this->typable_type);
    }

    public function typable()
    {
        return $this->morphTo();
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function bonus(): BelongsTo
    {
        return $this->belongsTo(Bonus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
