<?php

namespace App\Models\Players\Actions\Lists;

use App\Models\Helpers\Lists\Actions\CalculatePaginationLastPage;
use App\Models\Players\DTOs\PlayerListData;
use App\Models\Players\DTOs\PlayerListQueryData;
use App\Models\Players\Player;
use Exception;

class BuildPlayersListData
{
    public PlayerListData $playerListData;

    public function __construct(PlayerListQueryData $playerListQueryData)
    {
        $this->build($playerListQueryData);
    }

    public static function from(PlayerListQueryData $playerListQueryData): BuildPlayersListData
    {
        return new BuildPlayersListData($playerListQueryData);
    }

    public function build(PlayerListQueryData $playerListQueryData): void
    {
        try {
            $playersQuery = Player::with('position', 'nationality')
                ->join('countries', 'nationality_id', 'external_country_id')
                ->join('player_positions', 'position_id', 'external_position_id');

            // Add Search
            $playersQuery = BuildPlayersSearchQuery::fromSearchTerm(
                $playersQuery,
                $playerListQueryData->searchTerm
            )->playersQuery;

            // Filters
            $playersQuery = BuildCountriesFilterQuery::fromFilterCountryId(
                $playersQuery,
                $playerListQueryData->filterCountryId
            )->playersQuery;

            // Sort
            $playersQuery = BuildPlayersSortQuery::fromSortId(
                $playersQuery,
                $playerListQueryData->sortId
            )->playersQuery;

            $lastPage = CalculatePaginationLastPage::fromQuery($playersQuery, $playerListQueryData->limit);

            $players = $playersQuery->orderBy('players.id')
                ->offset(($playerListQueryData->currentPage - 1) * $playerListQueryData->limit)
                ->limit($playerListQueryData->limit)
                ->get(['players.*']);

            $this->playerListData = new PlayerListData(collect($players), $lastPage);

        } catch (Exception $e) {
            info($e);
            // \Sentry\captureMessage('Players List View: Building list query data failed');

            $this->playerListData = new PlayerListData(collect(), 1);
        }
    }
}
