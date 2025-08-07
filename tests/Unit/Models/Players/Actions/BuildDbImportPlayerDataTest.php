<?php

namespace Tests\Unit\Models\Players\Actions;

use App\Models\Players\Actions\BuildDbImportPlayerData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BuildDbImportPlayerDataTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_works_when_no_players_provided(): void
    {
        $data = BuildDbImportPlayerData::fromCollection(collect())->data;

        $this->assertCount(0, $data);
        $this->assertEquals($data, collect());
    }

    #[Test]
    public function it_works_when_there_is_an_error_building_the_players_data(): void
    {
        $data = BuildDbImportPlayerData::fromCollection(collect([
            ['id' => 1, 'name' => 'Country Name 1'], // missing data
        ]))->data;

        $this->assertCount(0, $data);
        $this->assertEquals($data, collect());
    }

    #[Test]
    public function it_works_building_the_players_data(): void
    {
        $dob  = now()->format('Y-m-d');
        $data = BuildDbImportPlayerData::fromCollection(collect([
            ['id' => 1, 'firstname' => 'Name One', 'lastname' => 'Last Name One', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'male', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_one'],
            ['id' => 2, 'firstname' => 'Name Two', 'lastname' => 'Last Name Two', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'female', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_two'],
            ['id' => 3, 'firstname' => 'Name Three', 'lastname' => 'Last Name Three', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'male', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_three'],
            ['id' => 4, 'firstname' => 'Name Four', 'lastname' => 'Last Name Four', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'female', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_four'],
            ['id' => 5, 'firstname' => 'Name Five', 'lastname' => 'Last Name Five', 'date_of_birth' => $dob, 'nationality_id' => 1, 'gender' => 'male', 'detailed_position_id' => 1, 'type_id' => 2, 'image_path' => 'player_name_five'],
        ]))->data;

        $this->assertInstanceOf(Collection::class, $data);
        $this->assertCount(5, $data);
        $this->assertEquals($data[0], [
            'external_player_id' => 1,
            'first_name'         => 'Name One',
            'last_name'          => 'Last Name One',
            'date_of_birth'      => $dob,
            'gender'             => 'male',
            'nationality_id'     => 1,
            'position_id'        => 1,
            'parent_position_id' => 2,
            'image_path'         => 'player_name_one',
        ]);
    }
}
