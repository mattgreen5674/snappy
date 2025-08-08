<?php

namespace App\Models\Players\Actions\Lists;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BuildPlayersSearchQuery
{
    public function __construct(
        public Builder $playersQuery
    ) {}

    public static function fromSearchTerm(Builder $playersQuery, string $searchTerm): BuildPlayersSearchQuery
    {
        if (Str::length($searchTerm) >= 3) {
            $playersQuery->where('first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('countries.name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('player_positions.name', 'LIKE', '%' . $searchTerm . '%');
        }

        return new BuildPlayersSearchQuery($playersQuery);
    }
}
