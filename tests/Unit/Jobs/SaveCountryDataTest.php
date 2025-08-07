<?php

namespace Tests\Unit\Models\Countries;

use App\Jobs\SportsMonk\SaveCountryData;
use App\Models\Countries\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SaveCountryDataTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_works_when_no_countries_provided(): void
    {
        $saveCountryData = new SaveCountryData(collect());
        $saveCountryData->handle();

        $this->assertDatabaseMissing(Country::class, []);
    }

    #[Test]
    public function it_logs_an_error_if_upsert_fails(): void
    {
        Log::spy();

        $countries = collect([
            ['id' => 1, 'name' => null, 'fifa_name' => null, 'image_path' => null],
        ]);

        Log::shouldReceive('info')->with(Mockery::on(function ($arg) {
            return is_array($arg) && str_contains($arg[0], 'sports monk import countries data - db data import error');
        }));

        $job = new SaveCountryData($countries);
        $job->handle();

        $this->assertDatabaseCount(Country::class, 0);
    }

    #[Test]
    public function it_works_building_the_countries_data(): void
    {
        $countries = collect([
            ['id' => 1, 'name' => 'Country Name 1', 'fifa_name' => 'one', 'image_path' => 'country_name_one'],
            ['id' => 2, 'name' => 'Country Name 2', 'fifa_name' => 'two', 'image_path' => 'country_name_two'],
            ['id' => 3, 'name' => 'Country Name 3', 'fifa_name' => 'the', 'image_path' => 'country_name_three'],
            ['id' => 4, 'name' => 'Country Name 4', 'fifa_name' => 'fou', 'image_path' => 'country_name_four'],
            ['id' => 5, 'name' => 'Country Name 5', 'fifa_name' => 'fiv', 'image_path' => 'country_name_five'],
        ]);

        $saveCountryData = new SaveCountryData($countries);
        $saveCountryData->handle();

        $this->assertDatabaseCount(Country::class, 5);

        foreach ($countries as $country) {
            $this->assertDatabaseHas(Country::class, [
                'external_country_id' => $country['id'],
                'name'                => $country['name'],
                'fifa_name'           => $country['fifa_name'],
                'image_path'          => $country['image_path'],
            ]);
        }
    }
}
