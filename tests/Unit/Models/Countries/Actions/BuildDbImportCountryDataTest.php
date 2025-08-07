<?php

namespace Tests\Unit\Models\Countries\Actions;

use App\Models\Countries\Actions\BuildDbImportCountryData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BuildDbImportCountryDataTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_works_when_no_countries_provided(): void
    {
        $data = BuildDbImportCountryData::fromCollection(collect())->data;

        $this->assertCount(0, $data);
        $this->assertEquals($data, collect());
    }

    #[Test]
    public function it_works_when_there_is_an_error_building_the_countries_data(): void
    {
        $data = BuildDbImportCountryData::fromCollection(collect([
            ['id' => 1, 'name' => 'Country Name 1'], // missing data 
        ]))->data;

        $this->assertCount(0, $data);
        $this->assertEquals($data, collect());
    }

    #[Test]
    public function it_works_building_the_countries_data(): void
    {
        $data = BuildDbImportCountryData::fromCollection(collect([
            ['id' => 1, 'name' => 'Country Name 1', 'fifa_name' => 'one', 'image_path' => 'country_name_one'],
            ['id' => 2, 'name' => 'Country Name 2', 'fifa_name' => 'two', 'image_path' => 'country_name_two'],
            ['id' => 3, 'name' => 'Country Name 3', 'fifa_name' => 'the', 'image_path' => 'country_name_three'],
            ['id' => 4, 'name' => 'Country Name 4', 'fifa_name' => 'fou', 'image_path' => 'country_name_four'],
            ['id' => 5, 'name' => 'Country Name 5', 'fifa_name' => 'fiv', 'image_path' => 'country_name_five'],
        ]))->data;

        $this->assertInstanceOf(Collection::class, $data);
        $this->assertCount(5, $data);
        $this->assertEquals($data[0], [
            'external_country_id' =>1,
            'name'                => 'Country Name 1',
            'fifa_name'           => 'one',
            'image_path'          => 'country_name_one',
        ]);
    }
}
