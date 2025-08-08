<?php

namespace Tests\Feature\Views\Players\Lists;

use App\Models\Countries\Country;
use App\Models\Players\Actions\Lists\BuildCountriesFilterData;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BuildCountriesFilterDataTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_builds_countries_collection_successfully()
    {
        // Arrange: create some countries
        Country::factory()->create([
            'external_country_id' => 1,
            'name'                => 'Brazil',
        ]);

        Country::factory()->create([
            'external_country_id' => 2,
            'name'                => 'Argentina',
        ]);

        $filterData = new BuildCountriesFilterData;

        $this->assertInstanceOf(Collection::class, $filterData->countries);
        $this->assertEquals([0 => 'All', 2 => 'Argentina', 1 => 'Brazil'], $filterData->countries->toArray());
    }

    #[Test]
    public function it_returns_collection_with_only_all_on_exception()
    {
        // Mock the Country model's static get method to throw an exception
        $this->mock(Country::class, function (MockInterface $mock) {
            $mock->shouldReceive('get')->andThrow(new Exception('DB error'));
        });

        $filterData = new BuildCountriesFilterData;

        $this->assertInstanceOf(Collection::class, $filterData->countries);
        $this->assertCount(1, $filterData->countries);
        $this->assertEquals([0 => 'All'], $filterData->countries->toArray());
    }
}
