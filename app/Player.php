<?php

namespace App;

use App\Traits\FindExternalId;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use FindExternalId;

    protected $table = 'players';
}
