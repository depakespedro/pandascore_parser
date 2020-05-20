<?php

namespace App\Repositories;


use App\Contracts\LeaguesManagerContract;
use App\League;

class LeaguesManager implements LeaguesManagerContract
{
    public function firstOrCreate (object $data): League {

        $model = League::firstOrCreate([
            'external_id' => $data->id,
            'name' => $data->name,
            'slug' => $data->slug,
            'image_url' => $data->image_url,
            'url' => $data->image_url,
        ]);

        return $model;
    }
}
