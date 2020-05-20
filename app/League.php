<?php

namespace App;

use App\Traits\FindExternalId;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use FindExternalId;

    protected $table = 'leagues';

    protected $fillable = [
        'external_id',
        'name',
        'slug',
        'image_url',
        'url',
    ];

    public function matches () {
        return $this->hasMany(Match::class);
    }
}
