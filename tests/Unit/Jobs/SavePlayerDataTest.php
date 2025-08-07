<?php

namespace Tests\Unit\Models\Countries;

use App\Jobs\SportsMonk\SavePlayerData;
use App\Models\Countries\Country;
use App\Models\Players\Player;
use App\Models\Players\Position;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SavePlayerDataTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_works_when_no_players_provided(): void
    {
        $saveCountryData = new SavePlayerData(collect());
        $saveCountryData->handle();

        $this->assertDatabaseMissing(Player::class, []);
    }

    #[Test]
    public function it_logs_an_error_if_upsert_fails(): void
    {
        Log::spy();
        
        $countries = collect([
            ['id' => 1, 'name' => null, 'fifa_name' => null, 'image_path' => null]
        ]);

        Log::shouldReceive('info')->with(Mockery::on(function ($arg) {
            return is_array($arg) && str_contains($arg[0], 'sports monk import players data - db data import error');
        }));

        $job = new SavePlayerData($countries);
        $job->handle();

        $this->assertDatabaseCount(Player::class, 0);
    }

    #[Test]
    public function it_works_building_the_players_data(): void
    {
        Country::factory()->create(['external_country_id' => 1]);
        Position::factory()->create(['external_position_id' => 1]);
        Position::factory()->create(['external_position_id' => 2]);
        $dob     = now()->format('Y-m-d');
        $players = collect([
            ['id' => 1, 'firstname' => 'Name One', 'lastname' => 'Last Name One', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'male', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_one'],
            ['id' => 2, 'firstname' => 'Name Two', 'lastname' => 'Last Name Two', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'female', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_two'],
            ['id' => 3, 'firstname' => 'Name Three', 'lastname' => 'Last Name Three', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'male', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_three'],
            ['id' => 4, 'firstname' => 'Name Four', 'lastname' => 'Last Name Four', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'female', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_four'],
            ['id' => 5, 'firstname' => 'Name Five', 'lastname' => 'Last Name Five', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'male', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_five'],
        ]);

        $saveCountryData = new SavePlayerData($players);
        $saveCountryData->handle();

        $this->assertDatabaseCount(Player::class, 5);

        foreach ($players as $player) {
            $this->assertDatabaseHas(Player::class, [
                'external_player_id' => $player['id'],
                'first_name'         => $player['firstname'],
                'last_name'          => $player['lastname'],
                'date_of_birth'      => $player['date_of_birth'],
                'gender'             => $player['gender'],
                'position_id'        => $player['detailed_position_id'],
                'parent_position_id' => $player['type_id'],
                'nationality_id'     => $player['nationality_id'],
                'image_path'         => $player['image_path'],
            ]);
        }
    }
}
