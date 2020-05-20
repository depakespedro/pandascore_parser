<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'external_id',
        'name',
        'slug',
    ];

    public function league () {
        return $this->belongsTo(League::class);
    }

    public function players()
    {
        return $this->morphedByMany('App\Player', 'opponentsable', 'opponents');
    }

    public function teams()
    {
        return $this->morphedByMany('App\Team', 'opponentsable', 'opponents');
    }

    public function opponents()
    {
        $teams = $this->teams;
        $players = $this->players;

        return $teams->merge($players);
    }
}
