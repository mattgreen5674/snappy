<?php

namespace Tests\Unit\Models\Countries;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\TestData\PlayerTestData;

class CountryModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function check_country_model_player_nationality_relationship_works(): void
    {
        $data = PlayerTestData::build(5);

        $this->assertCount(5, $data['country']->players);
        $this->assertEquals($data['country']->players[0]->full_name, $data['players'][0]->full_name);
    }
}
