<?php

namespace App\Console\Commands\SportsMonk;

use App\Clients\Countries as SportsMonkCountryClient;
use App\Jobs\SportsMonk\SaveCountryData;
use Exception;
use Illuminate\Console\Command;

class CountriesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:countries-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import country data from Sports Monk';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('sports monk import countries data - started');

        $lastId  = 0; // We will attempt to get the first 1,000 records - there should never really be more countries than this, but you never know!
        $hasNext = false;

        do {
            try {
                $client   = new SportsMonkCountryClient;
                $response = $client->list($lastId);

                $countries = collect(data_get($response, 'data', []));    

                if ($countries->isNotEmpty()) {
                    SaveCountryData::dispatch($countries);

                    $lastId  = $countries->last()['id'];
                    $hasNext = data_get($response, 'meta.has_more', false);

                } else {
                    info('sports monk import countries data - no records to import');
                    $hasNext = false;
                }
            } catch (Exception $e) {
                info(['sports monk import countries data - error', $e->getMessage()]);
                $hasNext = false;
            }
        } while ($hasNext);

        info('sports monk import countries data - finished');
    }
}
