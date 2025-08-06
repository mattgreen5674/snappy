<?php

namespace Tests\Feature\Clients\SportsMonk;

use App\Clients\SportsMonk as SportsMonkApiClient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SportsMonkClientTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_new_sports_monk_client(): void
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        
        $client = new SportsMonkApiClient;

        $this->assertEquals(['api_token' => 'sp0rt5MoNKT3stApiKEy'], $client->parameters);
        $this->assertNotNull($client);
    }

    #[Test]
    public function it_throws_an_exception_when_config_is_invalid()
    {
        Config::set('sportsmonk.api.base_url', null);
        Config::set('sportsmonk.api.key', null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Sports Monk API connection failed');

        new SportsMonkApiClient();
    }

    #[Test]
    public function it_builds_the_maximum_records_all_records_query_parameter()
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $client = new SportsMonkApiClient();
        $client->buildQueryParameters();

        $this->assertEquals([
            'api_token' => 'sp0rt5MoNKT3stApiKEy',
            'filters'   => 'populate', // this still only allows a maximum of 1000 records per request
        ], $client->parameters);
    }

    #[Test]
    public function it_builds_the_allowed_per_page_records_query_parameter()
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $client = new SportsMonkApiClient();
        $client->buildQueryParameters(0, 25);

        $this->assertEquals([
            'api_token' => 'sp0rt5MoNKT3stApiKEy',
            'per_page'  => 25,
        ], $client->parameters);
    }

    #[Test]
    public function it_doesnt_build_the_per_page_records_query_parameter_when_it_exceeds_maximum_of_50()
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $client = new SportsMonkApiClient();
        $client->buildQueryParameters(0, 150);

        $this->assertEquals([
            'api_token' => 'sp0rt5MoNKT3stApiKEy',
        ], $client->parameters);
    }

    #[Test]
    public function it_build_the_id_after_records_query_parameter()
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');

        $client = new SportsMonkApiClient();
        $client->buildQueryParameters(1234);

        $this->assertEquals([
            'api_token' => 'sp0rt5MoNKT3stApiKEy',
            'idAfter'   => 1234,
            'filters'   => 'populate',
        ], $client->parameters);
    }
}
