<?php

namespace App\Models\Players\Acions\Lists;

use Illuminate\Database\Eloquent\Builder;

class BuildPlayersCountryFilterQuery
{
    public function __construct(
        public Builder $playersQuery
    ) {}

    public static function fromFilterCountryId(Builder $playersQuery, int $filterCountryId): BuildPlayersSortQuery
    {
        // 0 = All
        if ($filterCountryId != 0) {
            $playersQuery->where('nationality_id', $filterCountryId);
        }

        return new BuildPlayersSortQuery($playersQuery);
    }
}
