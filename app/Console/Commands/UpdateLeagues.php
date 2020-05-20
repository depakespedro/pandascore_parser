<?php

namespace App\Console\Commands;

use App\Contracts\LeaguesManagerContract;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateLeagues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:leagues';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command is update leagues from api';

    /**
     * Uri for league api
     */
    private $path = '/leagues';
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
        $leaguesManager = app(LeaguesManagerContract::class);
        $url = env('BASE_API_URL') . $this->path . '?token=' . $this->token . '&per_page=' . $this->chunk_size . '&sort=id';

        $page = Cache::get('last_page_leagues', 1);

        do {

            $response = Http::get($url . '&page=' . $page);

            if (!$response->ok()) {
                Log::warning("UpdateLeagues: error get leagues, page: $page, per_page: {$this->chunk_size}");
            }

            $leagues = json_decode($response);

            if (is_null($leagues)) {
                Log::error("UpdateLeagues: error parse data, page: $page, per_page: {$this->chunk_size}");
                break;
            }

            foreach ($leagues as $league) {
                $leagueModel = $leaguesManager->firstOrCreate($league);
            }

            $page++;
        } while (count($leagues) !== 0);

        Cache::add('last_page_leagues', $page);
    }
}
