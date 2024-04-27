<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PgLog extends Model
{
    use SoftDeletes;

    protected $table = 'pg_logs';

    protected $fillable = [
        'name',
        'request',
    ];

    protected $casts = [
        'request' => 'array',
    ];
}
