<?php

namespace Tests\Unit\Models\Players;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\TestData\PlayerTestData;

class PositionModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function check_position_model_player_relationship_works(): void
    {
        $data = PlayerTestData::build(5);

        $this->assertCount(5, $data['position']->players);
        $this->assertEquals($data['position']->players[0]->full_name, $data['players'][0]->full_name);
    }

    #[Test]
    public function check_parent_position_model_player_relationship_works(): void
    {
        $data = PlayerTestData::build(5);

        $this->assertCount(5, $data['parentPosition']->parentPlayers);
        $this->assertEquals($data['parentPosition']->parentPlayers[0]->full_name, $data['players'][0]->full_name);
    }
}
