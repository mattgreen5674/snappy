<?php

namespace Tests\Feature\Commands;

use App\Jobs\SportsMonk\SavePlayerData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PlayerImportCommandTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_dispatches_job_with_player_data()
    {
        Bus::fake();

        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $url  = 'https://sports_monk_test_api_url/api/football/players?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';
        $data = [
            'data' => [
                ['id' => 1, 'firstname' => 'Name A', 'lastname' => 'Last Name A', 'country_id' => 1, 'position_id' => 1, 'type_id' => 1],
                ['id' => 2, 'firstname' => 'Name B', 'lastname' => 'Last Name B', 'country_id' => 1, 'position_id' => 1, 'type_id' => 1],
            ],
            'meta'       => [],
            'pagination' => [
                'has_more' => false,
            ],
        ];

        Http::fake([$url => Http::response($data, 200)]);

        $this->artisan('app:players-import')->assertExitCode(0);

        Bus::assertDispatched(SavePlayerData::class, 1);
        Bus::assertDispatched(function (SavePlayerData $job) {
            return $job->players[0]['id'] === 1;
        });
    }

    #[Test]
    public function it_dispatches_jobs_with_multiple_country_data()
    {
        // Currently set to only llop one until we understand the number of records to be saved
        // The number of calls to the API this would create and impacts on running time / rate limiting
        // leave as a risky test to remind us to revisit!!

        // Bus::fake();

        // Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        // Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        // $url1  = 'https://sports_monk_test_api_url/api/football/players?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';
        // $data1 = [
        //     'data' => [
        //         ['id' => 1, 'firstname' => 'Name A', 'lastname' => 'Last Name A', 'country_id' => 1, 'position_id' => 1, 'type_id' => 1],
        //         ['id' => 2, 'firstname' => 'Name B', 'lastname' => 'Last Name B', 'country_id' => 1, 'position_id' => 1, 'type_id' => 1],
        //     ],
        //     'meta'       => [],
        //     'pagination' => [
        //         'has_more' => true,
        //     ]
        // ];

        // $url2  = 'https://sports_monk_test_api_url/api/football/players?api_token=sp0rt5MoNKT3stApiKEy&idAfter=2&filters=populate';
        // $data2 = [
        //     'data' => [
        //         ['id' => 1, 'firstname' => 'Name C', 'lastname' => 'Last Name C', 'country_id' => 1, 'position_id' => 1, 'type_id' => 1],
        //     ],
        //     'meta'       => [],
        //     'pagination' => [
        //         'has_more' => false,
        //     ]
        // ];

        // Http::fake([
        //     $url1 => Http::response($data1, 200),
        //     $url2 => Http::response($data2, 200),
        // ]);

        // $this->artisan('app:players-import')->assertExitCode(0);

        // Bus::assertDispatched(SavePlayerData::class, 2);
        // Bus::assertDispatched(function (SavePlayerData $job) {
        //     return $job->players[0]['id'] === 1;
        // });
        // Bus::assertDispatched(function (SavePlayerData $job) {
        //     return $job->players[0]['id'] === 3;
        // });
    }

    #[Test]
    public function it_dispatches_no_jobs_when_country_data_empty()
    {
        Bus::fake();

        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $url  = 'https://sports_monk_test_api_url/api/football/players?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';
        $data = [
            'data'       => [],
            'meta'       => [],
            'pagination' => [
                'has_more' => false,
            ],
        ];

        Http::fake([$url => Http::response($data, 200)]);

        $this->artisan('app:players-import')->assertExitCode(0);

        Bus::assertNotDispatched(SavePlayerData::class);
    }

    #[Test]
    public function it_handles_exception_and_logs_error()
    {
        Bus::fake();
        Log::spy();

        Config::set('sportsmonk.api.base_url', null);
        Config::set('sportsmonk.api.key', null);

        Log::shouldReceive('info')->with(Mockery::on(function ($arg) {
            return is_array($arg) && str_contains($arg[0], 'sports monk import players data - error');
        }));

        $this->artisan('app:players-import')->assertExitCode(0);

        Bus::assertNotDispatched(SavePlayerData::class);
    }
}
