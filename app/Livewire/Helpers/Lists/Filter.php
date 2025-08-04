<?php

namespace App\Livewire\Helpers\Lists;

use Illuminate\Support\Collection;
use Livewire\Component;

class Filter extends Component
{
    public Collection $options;
    public int|string $selected;
    public int|string $resetSelected;
    public string $selectName;
    public string $filterName = 'filter-update';

    public function mount(): void
    {
        $this->resetSelected ??= $this->selected;
    }

    public function render()
    {
        return view('livewire.helpers.lists.filter');
    }

    public function updatedSelected(): void
    {
        $this->dispatch($this->filterName, selected: $this->selected);
    }

    public function resetFilter(): void
    {
        $this->selected = $this->resetSelected;
        $this->updatedSelected();
    }
}
