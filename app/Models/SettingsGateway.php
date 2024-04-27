<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'credentials',
        'is_active'
    ];

    protected $casts = [
        'credentials' => 'json',
        'is_active' => 'boolean'
    ];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }
}
