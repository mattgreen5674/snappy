<?php

namespace Tests\TestData;

use App\Models\Countries\Country;
use App\Models\Players\Player;
use App\Models\Players\Position;

class PlayerTestData
{
    public static function build(int $playersToBuild = 1): array
    {
        $dbCountry        = Country::factory()->create(['external_country_id' => 1000, 'name' => 'TestCountry']);
        $dbPosition       = Position::factory()->create(['external_position_id' => 1000, 'name' => 'TestPosition']);
        $dbParentPosition = Position::factory()->create(['external_position_id' => 1001, 'name' => 'TestParentPosition']);
        $dbPlayers        = collect();
        for ($i = 1; $i <= $playersToBuild; $i++) {
            $dbPlayer         = Player::factory()->create([
                'external_player_id' => 1000 + $i - 1,
                'first_name'         => 'Test',
                'last_name'          => 'Player',
                'nationality_id'     => $dbCountry->external_country_id,
                'position_id'        => $dbPosition->external_position_id,
                'parent_position_id' => $dbParentPosition->external_position_id,
            ]);

            $dbPlayers->push($dbPlayer);
        }

        $data = [
            'country'        => $dbCountry,
            'position'       => $dbPosition,
            'parentPosition' => $dbParentPosition,
        ];

        $data = ($playersToBuild == 1)
            ? array_merge($data, ['player'  => $dbPlayers->first()])
            : array_merge($data, ['players' => $dbPlayers]);

        return $data;
    }
}
