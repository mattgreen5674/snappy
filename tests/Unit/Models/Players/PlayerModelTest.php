<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\TestData\PlayerTestData;

class PlayerModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function check_player_model_nationality_relationship_works(): void
    {
        $data = PlayerTestData::build();

        $this->assertEquals($data['player']->nationality->name, $data['country']->name);
    }

    #[Test]
    public function check_player_model_position_relationship_works(): void
    {
        $data = PlayerTestData::build();

        $this->assertEquals($data['player']->position->name, $data['position']->name);
    }

    #[Test]
    public function check_player_model_parent_position_relationship_works(): void
    {
        $data = PlayerTestData::build();

        $this->assertEquals($data['player']->parentPosition->name, $data['parentPosition']->name);
    }

    #[Test]
    public function check_player_model_full_name_custom_attribute_works(): void
    {
        $data = PlayerTestData::build();

        $this->assertEquals($data['player']->full_name, $data['player']->first_name . ' ' . $data['player']->last_name);
    }
}
