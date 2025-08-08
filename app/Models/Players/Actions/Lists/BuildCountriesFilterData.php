<?php

namespace App\Models\Players\Actions\Lists;

use App\Models\Countries\Country;
use Exception;
use Illuminate\Support\Collection;

class BuildCountriesFilterData
{
    public Collection $countries;

    public function __construct()
    {
        $this->build();
    }

    public static function get(): BuildCountriesFilterData
    {
        return new BuildCountriesFilterData;
    }

    public function build(): void
    {
        try {
            $this->countries = Country::get()->mapWithKeys(function ($country) {
                return [$country->external_country_id => $country->name];
            })->sort()->prepend('All', 0);

        } catch (Exception $e) {
            info($e);
            // \Sentry\captureMessage('Players List View: Building countries filter query data failed');

            $this->countries = collect()->prepend('All', 0); // should always be at least the all option!
        }
    }
}
