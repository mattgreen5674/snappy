<?php

namespace App\Livewire\Helpers\Lists;

use Livewire\Component;

class Search extends Component
{
    public string $searchTerm = '';
    public string $searchName;

    public function render()
    {
        return view('livewire.helpers.lists.search');
    }

    public function updatedSearchTerm(): void
    {
        $this->dispatch('search-update', searchTerm: $this->searchTerm);
    }

    public function resetSearch(): void
    {
        $this->searchTerm = '';
        $this->updatedSearchTerm();
    }
}
