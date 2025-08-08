<?php

namespace Tests\Feature\Livewire\Helpers\Lists;

use App\Livewire\Helpers\Lists\Search;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SearchTest extends TestCase
{
    #[Test]
    public function it_renders_the_search_view()
    {
        Livewire::test(Search::class)
            ->assertViewIs('livewire.helpers.lists.search');
    }

    #[Test]
    public function it_dispatches_event_when_search_term_is_updated()
    {
        Livewire::test(Search::class)
            ->set('searchTerm', 'football')
            ->assertDispatched('search-update', searchTerm: 'football');
    }

    #[Test]
    public function it_resets_search_term_and_dispatches_event()
    {
        Livewire::test(Search::class)
            ->set('searchTerm', 'football')
            ->call('resetSearch')
            ->assertSet('searchTerm', '')
            ->assertDispatched('search-update', searchTerm: '');
    }
}
