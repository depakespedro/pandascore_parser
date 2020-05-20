<?php

namespace App\Console\Commands;

use App\Contracts\MatchesManagerContract;
use App\League;
use App\Match;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateMatches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:matches';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command is update matches from api';

    /**
     * Uri for matche api
     */
    private $path = '/matches';
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

        $this->chunk_size = env('CHUNK_SIZE');
        $this->token =  env('API_TOKEN');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $matchesManager = app(MatchesManagerContract::class);
        $url = env('BASE_API_URL') . $this->path . '?token=' . $this->token . '&per_page=' . $this->chunk_size . '&sort=id';

        $page = Cache::get('last_page_matches', 1);

        do {

            $response = Http::get($url . '&page=' . $page);

            if (!$response->ok()) {
                Log::warning("UpdateMatches: error get matches, page: $page, per_page: {$this->chunk_size}");
            }

            $matches = json_decode($response);

            if (is_null($matches)) {
                Log::error("UpdateMatches: error parse data, page: $page, per_page: {$this->chunk_size}");
                break;
            }

            foreach ($matches as $matche) {
                $matcheModel = $matchesManager->firstOrCreate($matche);
            }

            $page++;
        } while (count($matches) !== 0);

        Cache::add('last_page_matches', $page);
    }
}
