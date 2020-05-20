<?php

namespace App\Repositories;


use App\Contracts\MatchesManagerContract;
use App\League;
use App\Match;
use App\Player;
use App\Team;

class MatchesManager implements MatchesManagerContract
{
    public function firstOrCreate (object $data): Match {

        $match = Match::firstOrCreate([
            'external_id' => $data->id,
            'name' => $data->name,
            'slug' => $data->slug,
        ]);

        $league = League::findByExternalId($data->league_id)->get()->first();

        if ($league) {
            $match->league()->associate($league);
        }

        $opponentsRaw = $data->opponents;

        foreach ($opponentsRaw as $opponent) {
            if ($opponent->type === 'Team') {
                $team = Team::findByExternalId($opponent->opponent->id)->get()->first();
                if ($team) {
                    $match->teams()->save($team);
                }
            } elseif ($opponent->type === 'Player') {
                $player = Player::findByExternalId($opponent->opponent->id)->get()->first();
                if ($player) {
                    $match->players()->save($player);
                }
            }
        }

        $match->save();

        return $match;
    }
}
