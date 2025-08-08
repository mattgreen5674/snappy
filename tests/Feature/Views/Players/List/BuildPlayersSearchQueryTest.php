<?php

namespace Tests\Feature\Views\Players\List;

use App\Models\Countries\Country;
use App\Models\Players\Actions\Lists\BuildPlayersListData;
use App\Models\Players\DTOs\PlayerListQueryData;
use App\Models\Players\Player;
use App\Models\Players\Position;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\TestData\PlayerTestData;

class BuildPlayersSearchQueryTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_builds_players_list_data_for_default_display_amount(): void
    {
        $dbPlayers           = PlayerTestData::build(20); // Should create 2 pages
        $playerListQueryData = new PlayerListQueryData('', 0, 0, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->first_name == $dbPlayers['players'][0]->first_name);
        $this->assertTrue($playersListData->lastPage == 2);
    }

    #[Test]
    public function it_builds_players_list_data_for_differnt_display_amount(): void
    {
        $dbPlayers           = PlayerTestData::build(50); // Should create 2 pages
        $playerListQueryData = new PlayerListQueryData('', 0, 0, 1, config('snappy.pagination.limits.twenty_five'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(25, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->first_name == $dbPlayers['players'][0]->first_name);
        $this->assertTrue($playersListData->lastPage == 2);
    }

    #[Test]
    public function it_builds_players_list_data_for_page_two(): void
    {
        $dbPlayers           = PlayerTestData::build(20); // Should create 2 pages
        $playerListQueryData = new PlayerListQueryData('', 0, 0, 2, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->first_name == $dbPlayers['players'][10]->first_name);
        $this->assertTrue($playersListData->lastPage == 2);
    }

    #[Test]
    public function it_builds_players_list_data_in_player_name_asc_order(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        $names     = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            $dbPlayer->first_name = $names[$key];
            $dbPlayer->last_name  = $names[$key];
            $dbPlayer->save();
        }

        $playerListQueryData = new PlayerListQueryData('', 0, 1, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->first_name == 'A');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_in_player_name_desc_order(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        $names     = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            $dbPlayer->first_name = $names[$key];
            $dbPlayer->last_name  = $names[$key];
            $dbPlayer->save();
        }

        $playerListQueryData = new PlayerListQueryData('', 0, 2, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->first_name == 'J');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_in_country_name_asc_order(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        $names     = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            $dbCountry = Country::factory()->create([
                'external_country_id' => 2000 + $key,
                'name'                => $names[$key],
            ]);

            $dbPlayer->nationality_id = $dbCountry->external_country_id;
            $dbPlayer->save();
        }

        $playerListQueryData = new PlayerListQueryData('', 0, 3, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->nationality->name == 'A');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_in_country_name_desc_order(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        $names     = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            $dbCountry = Country::factory()->create([
                'external_country_id' => 2000 + $key,
                'name'                => $names[$key],
            ]);

            $dbPlayer->nationality_id = $dbCountry->external_country_id;
            $dbPlayer->save();
        }

        $playerListQueryData = new PlayerListQueryData('', 0, 4, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->nationality->name == 'J');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_in_position_name_asc_order(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        $names     = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            $dbPosition = Position::factory()->create([
                'external_position_id' => 3000 + $key,
                'name'                 => $names[$key],
            ]);

            $dbPlayer->position_id = $dbPosition->external_position_id;
            $dbPlayer->save();
        }

        $playerListQueryData = new PlayerListQueryData('', 0, 5, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->position->name == 'A');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_in_position_name_desc_order(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        $names     = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            $dbPosition = Position::factory()->create([
                'external_position_id' => 3000 + $key,
                'name'                 => $names[$key],
            ]);

            $dbPlayer->position_id = $dbPosition->external_position_id;
            $dbPlayer->save();
        }

        $playerListQueryData = new PlayerListQueryData('', 0, 6, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->position->name == 'J');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_filtered_by_country(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        $dbCountry = Country::factory()->create([
            'external_country_id' => 2000,
            'name'                => 'Country ' . 2000,
        ]);
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            if ($key % 2 == 0) {
                $dbPlayer->nationality_id = $dbCountry->external_country_id;
                $dbPlayer->save();
            }
        }

        $playerListQueryData = new PlayerListQueryData('', 2000, 0, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(5, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->nationality->name == 'Country 2000');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_but_ignores_search_term_when_less_than_three_characters(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            if ($key % 2 == 0) {
                $dbPlayer->first_name = 'Obscure';
                $dbPlayer->save();
            }
        }

        $playerListQueryData = new PlayerListQueryData('Ob', 0, 0, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(10, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->full_name == 'Obscure Player');
        $this->assertTrue($playersListData->players[1]->full_name == 'Test Player');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_when_search_term_is_minimum_of_three_characters(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            if ($key % 2 == 0) {
                $dbPlayer->first_name = 'Obscure';
                $dbPlayer->save();
            }
        }

        $playerListQueryData = new PlayerListQueryData('Obs', 0, 0, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(5, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->full_name == 'Obscure Player');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_by_first_name_search_term(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            if ($key % 2 == 0) {
                $dbPlayer->first_name = 'Obscure';
                $dbPlayer->save();
            }
        }

        $playerListQueryData = new PlayerListQueryData('Obscure', 0, 0, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(5, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->full_name == 'Obscure Player');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_by_last_name_search_term(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            if ($key % 2 == 0) {
                $dbPlayer->last_name = 'Obscure';
                $dbPlayer->save();
            }
        }

        $playerListQueryData = new PlayerListQueryData('Obscure', 0, 0, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(5, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->full_name == 'Test Obscure');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_by_country_name_search_term(): void
    {
        $dbPlayers = PlayerTestData::build(10); // Should create 1 pages
        Country::factory()->create([
            'external_country_id' => 2000,
            'name'                => 'Obscure Country',
        ]);
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            if ($key % 2 == 0) {
                $dbPlayer->nationality_id = 2000;
                $dbPlayer->save();
            }
        }

        $playerListQueryData = new PlayerListQueryData('Obscure', 0, 0, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(5, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->nationality->name == 'Obscure Country');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    #[Test]
    public function it_builds_players_list_data_by_position_name_search_term(): void
    {
        $dbPlayers  = PlayerTestData::build(10); // Should create 1 pages
        Position::factory()->create([
            'external_position_id' => 3000,
            'name'                 => 'Obscure Position',
        ]);
        foreach ($dbPlayers['players'] as $key => $dbPlayer) {
            if ($key % 2 == 0) {
                $dbPlayer->position_id = 3000;
                $dbPlayer->save();
            }
        }

        $playerListQueryData = new PlayerListQueryData('Obscure', 0, 0, 1, config('snappy.pagination.limits.ten'));
        $playersListData     = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertCount(5, $playersListData->players);
        $this->assertTrue($playersListData->players[0]->position->name == 'Obscure Position');
        $this->assertTrue($playersListData->lastPage == 1);
    }

    public function it_handles_build_player_list_data_exceptions()
    {
        $playerListQueryData = new PlayerListQueryData('', 0, 0, 1, config('snappy.pagination.limits.ten'));

        // Mock the Players model's static get method to throw an exception
        $this->mock(Player::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')->andThrow(new Exception('DB error'));
        });

        $playersListData = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->assertEmpty($playersListData->players);
        $this->assertEquals(1, $playersListData->lastPage);
    }
}
