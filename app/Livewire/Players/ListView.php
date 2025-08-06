<?php

namespace App\Livewire\Players;

use App\Models\Players\Actions\Lists\BuildCountriesFilterData;
use App\Models\Players\Actions\Lists\BuildPlayersListData;
use App\Models\Players\Actions\Lists\BuildSortOptionsData;
use App\Models\Players\DTOs\PlayerListQueryData;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ListView extends Component
{
    public collection $players;

    // Search
    public string $searchTerm = '';

    // Pagination
    public int $currentPage = 1;
    public int $lastPage    = 1;
    public int $limit;

    // Filters
    public collection $countries;
    public int $filterCountryId = 0;

    // Sorting
    public collection $sortOptions;
    public int $sortId = 0;

    public function mount(): void
    {
        $this->limit = config('snappy.pagination.limits.ten');
        $this->getPlayers();
        $this->getCountries();
        $this->getSortOptions();
    }

    public function render()
    {
        return view('livewire.players.list-view');
    }

    #[On('pagination-update')]
    public function paginationChange(int $newPage): void
    {
        $this->currentPage = $newPage;
        $this->getPlayers();
    }

    #[On('filter-update')]
    public function filterChange(int $selected): void
    {
        $this->filterCountryId = $selected;
        $this->getPlayers();
    }

    #[On('search-update')]
    public function searchChange(string $searchTerm): void
    {
        $this->searchTerm = $searchTerm;
        $this->getPlayers();
    }

    #[On('sort-update')]
    public function sortChange(int $selected): void
    {
        $this->sortId = $selected;
        $this->getPlayers();
    }

    public function getPlayers(): void
    {
        $playerListQueryData = new PlayerListQueryData(
            $this->searchTerm,
            $this->filterCountryId,
            $this->sortId,
            $this->currentPage,
            $this->limit
        );

        $playersListData = BuildPlayersListData::from($playerListQueryData)->playerListData;

        $this->lastPage = $playersListData->lastPage;
        $this->players  = $playersListData->players;
    }

    public function getCountries(): void
    {
        $this->countries = BuildCountriesFilterData::get()->countries;
    }

    public function getSortOptions(): void
    {
        $this->sortOptions = BuildSortOptionsData::get()->options;
    }
}
