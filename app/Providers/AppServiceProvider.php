<?php

namespace App\Providers;

use App\Contracts\LeaguesManagerContract;
use App\Contracts\MatchesManagerContract;
use App\Contracts\TeamsManagerContract;
use App\Repositories\LeaguesManager;
use App\Repositories\MatchesManager;
use App\Repositories\TeamsManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        TeamsManagerContract::class => TeamsManager::class,
        LeaguesManagerContract::class => LeaguesManager::class,
        MatchesManagerContract::class => MatchesManager::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
