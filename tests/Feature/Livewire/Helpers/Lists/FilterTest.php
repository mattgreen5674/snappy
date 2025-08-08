<?php

namespace Tests\Feature\Livewire\Helpers\Lists;

use App\Livewire\Helpers\Lists\Filter;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FilterTest extends TestCase
{
    #[Test]
    public function it_sets_reset_selected_on_mount()
    {
        Livewire::test(Filter::class, [
            'options' => collect(['A', 'B']),
            'selected' => 'B',
            'selectName' => 'my_filter',
        ])
        ->assertSet('resetSelected', 'B');
    }

    #[Test]
    public function it_dispatches_event_when_selected_is_updated()
    {
        Livewire::test(Filter::class, [
            'options' => collect(['A', 'B']),
            'selected' => 'A',
            'selectName' => 'my_filter',
        ])
        ->set('selected', 'B')
        ->assertDispatched('filter-update', selected: 'B');
    }

    #[Test]
    public function it_resets_selected_and_dispatches_event()
    {
        Livewire::test(Filter::class, [
            'options' => collect(['A', 'B']),
            'selected' => 'A',
            'selectName' => 'my_filter',
        ])
        ->set('selected', 'B')
        ->assertDispatched('filter-update', selected: 'B')
        ->call('resetFilter')
        ->assertSet('selected', 'A')
        ->assertDispatched('filter-update', selected: 'A');
    }
}
