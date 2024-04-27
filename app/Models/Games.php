<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Games extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'game_id',
        'user_id',
        'games_providers_id'
    ];

    protected static function boot()
    {
        parent::boot();

        Games::creating(function ($model) {
            $model->slug = Str::slug($model->name, '-');
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'games_user');
    }

    public function gamesProvider()
    {
        return $this->belongsTo(GamesProvider::class, 'games_providers_id');
    }

    //create accessor for image to retrieve public url
    public function getImageAttribute($image)
    {
        return asset('images/games-thumbnail/' . $image);
    }

}
