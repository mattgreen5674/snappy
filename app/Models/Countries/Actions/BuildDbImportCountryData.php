<?php

namespace App\Models\Countries\Actions;

use Exception;
use Illuminate\Support\Collection;

class BuildDbImportCountryData
{
    public function __construct(public Collection $data) {}

    public static function fromCollection(Collection $countries): BuildDbImportCountryData
    {
        try {
            $dbCountries = collect($countries)->map(function ($country) {
                return [
                    'external_country_id' => $country['id'],
                    'name'                => $country['name'],
                    'fifa_name'           => $country['fifa_name'],
                    'image_path'          => $country['image_path'],
                ];
            });
        } catch (Exception $e) {
            info(['sports monk countries data - build db country data error', $e->getMessage()]);

            return new BuildDbImportCountryData(collect());
        }

        return new BuildDbImportCountryData($dbCountries);
    }
}
