<?php

namespace App\Models;

use App\Models\Payment\Deposit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'fields',
    ];

    protected $casts = [
        'fields' => 'json',
    ];

    public function getCredentialsAttribute($value)
    {
        return json_decode(json_decode($value));
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function settings()
    {
        return $this->hasMany(SettingsGateway::class);
    }
}
