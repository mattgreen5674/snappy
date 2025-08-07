<?php

namespace Tests\Feature\Commands;

use App\Jobs\SportsMonk\SaveCountryData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CountryImportCommandTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_dispatches_job_with_country_data()
    {
        Bus::fake();

        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $url  = 'https://sports_monk_test_api_url/api/core/countries?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';
        $data = [
            'data' => [
                ['id' => 1, 'name' => 'Country A'],
                ['id' => 2, 'name' => 'Country B'],
            ],
            'meta'       => [],
            'pagination' => [
                'has_more' => false,
            ]
        ];

        Http::fake([$url => Http::response($data, 200)]);

        $this->artisan('app:countries-import')->assertExitCode(0);

        Bus::assertDispatched(SaveCountryData::class, 1);
        Bus::assertDispatched(function (SaveCountryData $job) {
            return $job->countries[0]['id'] === 1;
        });
    }

    #[Test]
    public function it_dispatches_jobs_with_multiple_country_data()
    {
        Bus::fake();

        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $url1  = 'https://sports_monk_test_api_url/api/core/countries?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';
        $data1 = [
            'data' => [
                ['id' => 1, 'name' => 'Country A'],
                ['id' => 2, 'name' => 'Country B'],
            ],
            'meta'       => [],
            'pagination' => [
                'has_more' => true,
            ]
        ];

        $url2  = 'https://sports_monk_test_api_url/api/core/countries?api_token=sp0rt5MoNKT3stApiKEy&idAfter=2&filters=populate';
        $data2 = [
            'data' => [
                ['id' => 3, 'name' => 'Country C'],
            ],
            'meta'       => [],
            'pagination' => [
                'has_more' => false,
            ]
        ];

        Http::fake([
            $url1 => Http::response($data1, 200),
            $url2 => Http::response($data2, 200),
        ]);

        $this->artisan('app:countries-import')->assertExitCode(0);

        Bus::assertDispatched(SaveCountryData::class, 2);
        Bus::assertDispatched(function (SaveCountryData $job) {
            return $job->countries[0]['id'] === 1;
        });
        Bus::assertDispatched(function (SaveCountryData $job) {
            return $job->countries[0]['id'] === 3;
        });
    }

    #[Test]
    public function it_dispatches_no_jobs_when_country_data_empty()
    {
        Bus::fake();

        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $url  = 'https://sports_monk_test_api_url/api/core/countries?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';
        $data = [
            'data' => [],
            'meta'       => [],
            'pagination' => [
                'has_more' => false,
            ]
        ];

        Http::fake([$url => Http::response($data, 200)]);

        $this->artisan('app:countries-import')->assertExitCode(0);

        Bus::assertNotDispatched(SaveCountryData::class);
    }

    #[Test]
    public function it_handles_exception_and_logs_error()
    {
        Bus::fake();
        Log::spy();

        Config::set('sportsmonk.api.base_url', null);
        Config::set('sportsmonk.api.key', null);

        Log::shouldReceive('info')->with(Mockery::on(function ($arg) {
            return is_array($arg) && str_contains($arg[0], 'sports monk import countries data - error');
        }));

        $this->artisan('app:countries-import')->assertExitCode(0);

        Bus::assertNotDispatched(SaveCountryData::class);
    }
}
