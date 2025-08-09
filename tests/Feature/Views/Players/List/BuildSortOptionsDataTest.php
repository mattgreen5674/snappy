<?php

namespace Tests\Feature\Views\Players\Lists;

use App\Models\Players\Actions\Lists\BuildSortOptionsData;
use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BuildSortOptionsDataTest extends TestCase
{
    #[Test]
    public function it_builds_countries_collection_successfully()
    {
        // Options are hard coded, so no DB queires
        $filterData = new BuildSortOptionsData;

        $this->assertInstanceOf(Collection::class, $filterData->options);
        $this->assertEquals([
            0 => 'None',
            1 => 'Name (A-Z)',
            2 => 'Name (Z-A)',
            3 => 'Nationality (A-Z)',
            4 => 'Nationality (Z-A)',
            5 => 'Position (A-Z)',
            6 => 'Position (Z-A)',
        ], $filterData->options->toArray());
    }
}
