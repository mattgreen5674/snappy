<?php

namespace App\Livewire\Helpers\Lists;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class Pagination extends Component
{
    #[Reactive]
    public int $currentPage;

    #[Reactive]
    public int $lastPage;

    public array $pagination = [];

    public function render()
    {
        $this->updatePagination();

        return view('livewire.helpers.lists.pagination');
    }

    public function updatePagination()
    {
        $this->pagination = [];

        if ($this->lastPage <= 5) {
            // Show all pages if the number of pages is small
            for ($i = 1; $i <= $this->lastPage; $i++) {
                $this->pagination[] = $i;
            }
        } else {
            if ($this->currentPage <= 3) {
                // Near beginning
                $this->pagination = array_merge($this->pagination, [1, 2, 3, 4, 'dots', $this->lastPage]);
            } elseif ($this->currentPage >= $this->lastPage - 2) {
                // Near end
                $this->pagination = array_merge($this->pagination, [1, 'dots', $this->lastPage - 3, $this->lastPage - 2, $this->lastPage - 1, $this->lastPage]);
            } else {
                // Middle range
                $this->pagination = array_merge($this->pagination, [1, 'dots', $this->currentPage - 1, $this->currentPage, $this->currentPage + 1, 'dots', $this->lastPage]);
            }
        }
    }

    public function update(int $newPage): void
    {
        $this->dispatch('pagination-update', newPage: $newPage);
    }
}
