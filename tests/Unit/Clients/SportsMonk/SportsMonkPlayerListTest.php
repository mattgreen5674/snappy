<?php

namespace Tests\Unit\Clients\SportsMonk;

use App\Clients\Players as SportsMonkPlayerListApiClient;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SportsMonkPlayerListTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_data_and_meta_when_api_response_is_successful(): void
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');
        $url = 'https://sports_monk_test_api_url/api/football/players?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';

        Http::fake([
            $url => Http::response([
                'data'         => ['player1', 'player2'], // I have not created a 1000 records to keep things neat.
                'subscription' => [
                    ['meta' => ['page' => 1, 'per_page' => 1000]],
                ],
                'pagination' => ['has_more' => true],
            ], 200),
        ]);

        $client = new SportsMonkPlayerListApiClient;
        $result = $client->list();

        $this->assertEquals(['player1', 'player2'], $result['data']);
        $this->assertEquals([
            'page'     => 1,
            'per_page' => 1000,
            'has_more' => true,
        ], $result['meta']);
    }

    #[Test]
    public function it_throws_exception_when_api_call_fails(): void
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');
        $url = 'https://sports_monk_test_api_url/api/football/players?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';

        Http::fake([
            $url => Http::response(['error' => 'Something went wrong'], 500),
        ]);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Sports Monk API getting players list failed');

        $client = new SportsMonkPlayerListApiClient;
        $client->list();
    }

    #[Test]
    public function it_calls_build_query_parameters_with_correct_values(): void
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');
        $url = 'https://sports_monk_test_api_url/api/football/players?api_token=sp0rt5MoNKT3stApiKEy&idAfter=2345&per_page=2';

        Http::fake([
            $url => Http::response([
                'data'         => ['player2345', 'player2346'],
                'subscription' => [
                    ['meta' => ['page' => 1, 'per_page' => 2]],
                ],
                'pagination' => ['has_more' => true],
            ], 200),
        ]);

        $client = new SportsMonkPlayerListApiClient;
        $result = $client->list(2345, 2);

        $this->assertEquals(['player2345', 'player2346'], $result['data']);
        $this->assertEquals([
            'page'     => 1,
            'per_page' => 2,
            'has_more' => true,
        ], $result['meta']);
    }

    #[Test]
    public function it_handles_missing_meta_gracefully(): void
    {
        Config::set('sportsmonk.api.base_url', 'https://sports_monk_test_api_url/api');
        Config::set('sportsmonk.api.key', 'sp0rt5MoNKT3stApiKEy');
        $url = 'https://sports_monk_test_api_url/api/football/players?api_token=sp0rt5MoNKT3stApiKEy&filters=populate';

        Http::fake([
            $url => Http::response([
                'data'         => [],
                'subscription' => [],
                'pagination'   => [],
            ], 200),
        ]);

        $client = new SportsMonkPlayerListApiClient;
        $result = $client->list();

        $this->assertEquals($result['data'], []);
        $this->assertEquals($result['meta'], ['has_more' => null]);
    }
}
