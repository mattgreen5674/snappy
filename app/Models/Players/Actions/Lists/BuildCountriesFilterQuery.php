<?php

namespace App\Models\Players\Actions\Lists;

use Illuminate\Database\Eloquent\Builder;

class BuildCountriesFilterQuery
{
    public function __construct(
        public Builder $playersQuery
    ) {}

    public static function fromFilterCountryId(Builder $playersQuery, int $filterCountryId): BuildCountriesFilterQuery
    {
        // 0 = All
        if ($filterCountryId != 0) {
            $playersQuery->where('nationality_id', $filterCountryId);
        }

        return new BuildCountriesFilterQuery($playersQuery);
    }
}
