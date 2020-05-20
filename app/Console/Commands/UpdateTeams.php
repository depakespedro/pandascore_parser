<?php

namespace App\Console\Commands;

use App\Contracts\TeamsManagerContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command is update teams from api';

    /**
     * Uri for teams api
     */
    private $path = '/teams';
    private $chunk_size = 100;
    private $token = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->chunk_size =  env('CHUNK_SIZE');
        $this->token =  env('API_TOKEN');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $teamsManager = app(TeamsManagerContract::class);
        $url = env('BASE_API_URL') . $this->path . '?token=' . $this->token . '&per_page=' . $this->chunk_size . '&sort=id';

        $page = Cache::get('last_page_teams', 1);

        do {

            $response = Http::get($url . '&page=' . $page);

            if (!$response->ok()) {
                Log::warning("UpdateTeams: error get teams, page: $page, per_page: {$this->chunk_size}");
            }

            $teams = json_decode($response);

            if (is_null($teams)) {
                Log::error("UpdateTeams: error parse data, page: $page, per_page: {$this->chunk_size}");
                break;
            }

            foreach ($teams as $team) {
                $teamModel = $teamsManager->firstOrCreate($team);
            }

            $page++;
        } while (count($teams) !== 0);

        Cache::add('last_page_teams', $page);
    }
}
