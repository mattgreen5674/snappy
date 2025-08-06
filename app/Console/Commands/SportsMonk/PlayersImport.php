<?php

namespace App\Console\Commands\SportsMonk;

use App\Clients\Players as SportsMonkPlayerClient;
use App\Jobs\SportsMonk\SavePlayerData;
use Exception;
use Illuminate\Console\Command;

class PlayersImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:players-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import player data from Sports Monk';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('sports monk import players data - started');

        $lastId  = 0; // We will attempt to get the first 1,000 records - there should never really be more countries than this, but you never know!
        $hasNext = false;

        do {
            try {
                $client   = new SportsMonkPlayerClient;
                $response = $client->list($lastId);

                $players = collect(data_get($response, 'data', []));

                if ($players->isNotEmpty()) {
                    SavePlayerData::dispatch($players);

                    $lastId  = $players->last()['id'];
                    // $hasNext = data_get($response, 'meta.has_more', false);

                    // Free subscription sports monk data does not provide details of total records
                    // As such is it difficult to calculate potential running times, so assumed given
                    // the number of supported leagues x teams x potential squad size (and former players)
                    // that this data would be quite considerable.
                    // This would definately need some thinking about, but here I am commenting out the loop
                    // code and limiting the import to the first 1,000 records.
                    $hasNext = false;

                } else {
                    info('sports monk import players data - no records to import');
                    $hasNext = false;
                }
            } catch (Exception $e) {
                info(['sports monk import players data - error', $e->getMessage()]);
                // \Sentry\captureMessage('sports monk import players failed');
                $hasNext = false;
            }
        } while ($hasNext);

        info('sports monk import players data - finished');
    }
}
