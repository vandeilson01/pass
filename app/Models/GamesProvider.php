<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GamesProvider extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'fields',
    ];

    protected $casts = [
        'fields' => 'array',
    ];

    protected $hidden = [
        'fields',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function games()
    {
        return $this->belongsToMany(Games::class);
    }
}
