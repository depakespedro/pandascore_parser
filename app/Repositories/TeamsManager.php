<?php

namespace App\Repositories;


use App\Contracts\TeamsManagerContract;
use App\Team;

class TeamsManager implements TeamsManagerContract
{
    public function firstOrCreate (object $data): Team {

        $model = Team::firstOrCreate([
            'external_id' => $data->id,
            'name' => $data->name,
            'acronym' => $data->acronym,
            'slug' => $data->slug,
            'location' => $data->location,
            'image_url' => $data->image_url,
        ]);

        return $model;
    }
}
