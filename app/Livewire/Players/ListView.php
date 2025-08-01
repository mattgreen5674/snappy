<?php

namespace App\Livewire\Players;

use App\Models\Helpers\Lists\Actions\DeterminePaginationLastPage;
use App\Models\Players\Player;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ListView extends Component
{
    public collection $players;

    // Pagination
    public int $currentPage = 1;
    public int $lastPage    = 1;
    public int $limit;
    public string $paginationKey;

    public function mount(): void
    {
        $this->limit = config('snappy.pagination.limits.ten');
        $this->getPlayers();
    }

    public function render()
    {
        return view('livewire.players.list-view');
    }

    #[On('pagination-update')]
    public function change(int $newPage): void
    {
        $this->currentPage = $newPage;
        $this->getPlayers();
    }

    public function getPlayers(): void
    {
        $playersQuery = Player::with('position', 'nationality');

        // Add Search
        // Filters
        // Sort

        $this->lastPage = DeterminePaginationLastPage::fromQuery($playersQuery, $this->limit);

        $playersQuery->orderBy('id')
            ->offset(($this->currentPage - 1) * $this->limit)
            ->limit($this->limit);

        $this->players       = $playersQuery->get();
        $this->paginationKey = md5(json_encode($this->players));
    }
}
