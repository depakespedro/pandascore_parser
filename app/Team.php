<?php

namespace App;

use App\Traits\FindExternalId;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use FindExternalId;

    protected $table = 'teams';

    protected $fillable = [
        'external_id',
        'name',
        'acronym',
        'slug',
        'location',
        'image_url',
    ];
}
