<?php

namespace App\Models\Players\Actions\Lists;

use Illuminate\Database\Eloquent\Builder;

class BuildPlayersSortQuery
{
    public function __construct(
        public Builder $playersQuery
    ) {}

    public static function fromSortId(Builder $playersQuery, int $sortId): BuildPlayersSortQuery
    {
        // 0 = none
        if ($sortId != 0) {
            switch ($sortId) {
                case 1:
                    $playersQuery->orderByRaw("CONCAT(first_name, ' ', last_name) ASC");
                    break;
                case 2:
                    $playersQuery->orderByRaw("CONCAT(first_name, ' ', last_name) DESC");
                    break;
                case 3:
                    $playersQuery->orderBy('countries.name');
                    break;
                case 4:
                    $playersQuery->orderByDesc('countries.name');
                    break;
                case 5:
                    $playersQuery->orderBy('player_positions.name');
                    break;
                case 6:
                    $playersQuery->orderByDesc('player_positions.name');
                    break;
                default:
                    break;
            }
        }

        return new BuildPlayersSortQuery($playersQuery);
    }
}
