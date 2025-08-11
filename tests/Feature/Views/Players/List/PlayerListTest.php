<?php

namespace Tests\Feature\Views\Players\Lists;

use App\Livewire\Helpers\Lists\Filter;
use App\Livewire\Helpers\Lists\Pagination;
use App\Livewire\Helpers\Lists\Search;
use App\Livewire\Players\ListView;
use App\Models\Countries\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\TestData\PlayerTestData;

class PlayerListTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_mounts_and_includes_all_live_wire_components()
    {
        PlayerTestData::build(60);

        Livewire::test(ListView::class)
            ->assertSeeLivewire(Search::class)
            ->assertSeeLivewire(Filter::class)
            ->assertSeeLivewire(Pagination::class)
            ->assertCount('players', 10)
            ->assertSet('searchTerm', '')
            ->assertSet('currentPage', 1)
            ->assertSet('lastPage', 6)
            ->assertSet('limit', config('snappy.pagination.limits.ten'))
            ->assertCount('countries', 2) // Test Country and All
            ->assertSet('countryFilterId', 0) // All's id
            ->assertCount('sortOptions', 7) // Default options and All
            ->assertSet('sortOptionsId', 0) // All's id
            ->assertSeeTextInOrder([
                'Players Search',
                'Country Filter',
                'Players Sort',
                '1', '2', '3', '4', '...', '6',
            ]);
    }

    #[Test]
    public function it_shows_no_players_message()
    {
        $data = PlayerTestData::build(1);
        $data['player']->delete();

        Livewire::test(ListView::class)
            ->assertSeeText('There are no players for this selection....');
    }

    #[Test]
    public function it_shows_players_details()
    {
        $data = PlayerTestData::build(1);

        Livewire::test(ListView::class)
            ->assertSeeTextInOrder([
                'Name', $data['player']->full_name,
                'Nationality', $data['country']->name,
                'Position', $data['position']->name,
                'View Details',
            ])
            ->assertSeeHtmlInOrder(['<a', 'href="', 'players/details/' . $data['player']->id . '"']);
    }

    #[Test]
    public function it_updates_current_page_when_pagination_event_is_fired()
    {
        $data = PlayerTestData::build(50);

        Livewire::test(ListView::class)
            ->set('currentPage', 1) // starting page
            ->assertSeeHtmlInOrder([
                'players/details/' . $data['players'][0]->id,
                'players/details/' . $data['players'][1]->id,
                'players/details/' . $data['players'][2]->id,
                'players/details/' . $data['players'][3]->id,
                'players/details/' . $data['players'][4]->id,
                'players/details/' . $data['players'][5]->id,
                'players/details/' . $data['players'][6]->id,
                'players/details/' . $data['players'][7]->id,
                'players/details/' . $data['players'][8]->id,
                'players/details/' . $data['players'][9]->id,
            ])
            ->dispatch('pagination-update', newPage: 5) // simulate event
            ->assertSet('currentPage', 5)
            ->assertSeeHtmlInOrder([
                'players/details/' . $data['players'][40]->id,
                'players/details/' . $data['players'][41]->id,
                'players/details/' . $data['players'][42]->id,
                'players/details/' . $data['players'][43]->id,
                'players/details/' . $data['players'][44]->id,
                'players/details/' . $data['players'][45]->id,
                'players/details/' . $data['players'][46]->id,
                'players/details/' . $data['players'][47]->id,
                'players/details/' . $data['players'][48]->id,
                'players/details/' . $data['players'][49]->id,
            ]);
    }

    #[Test]
    public function it_updates_filter_country_id_when_filter_event_is_fired()
    {
        $data = PlayerTestData::build(10);
        Country::factory()->create([
            'external_country_id' => 2000,
            'name'                => 'Filter Test Country',
        ]);
        foreach ($data['players'] as $key => $player) {
            if ($key % 2 == 0) {
                $player->nationality_id = 2000;
                $player->save();
            }
        }

        Livewire::test(ListView::class)
            ->assertSet('filterCountryId', 0) // starting value
            ->assertSeeHtmlInOrder([
                'players/details/' . $data['players'][0]->id,
                'players/details/' . $data['players'][1]->id,
                'players/details/' . $data['players'][2]->id,
                'players/details/' . $data['players'][3]->id,
                'players/details/' . $data['players'][4]->id,
                'players/details/' . $data['players'][5]->id,
                'players/details/' . $data['players'][6]->id,
                'players/details/' . $data['players'][7]->id,
                'players/details/' . $data['players'][8]->id,
                'players/details/' . $data['players'][9]->id,
            ])
            ->dispatch('filter-update', selected: 2000) // simulate event
            ->assertSet('filterCountryId', 2000) // 0 = All 2000 = Filter Test County 1000 = Test Country (they are sorted alphabetically)
            ->assertSeeHtmlInOrder([
                'players/details/' . $data['players'][0]->id,
                'players/details/' . $data['players'][2]->id,
                'players/details/' . $data['players'][4]->id,
                'players/details/' . $data['players'][6]->id,
                'players/details/' . $data['players'][8]->id,
            ]);
    }

    #[Test]
    public function it_updates_search_term_when_search_event_is_fired()
    {
        $data = PlayerTestData::build(10);
        foreach ($data['players'] as $key => $player) {
            if ($key % 2 == 0) {
                $player->last_name = 'Filter Player';
                $player->save();
            }
        }

        Livewire::test(ListView::class)
            ->set('searchTerm', '') // starting value
            ->assertSeeHtmlInOrder([
                'players/details/' . $data['players'][0]->id,
                'players/details/' . $data['players'][1]->id,
                'players/details/' . $data['players'][2]->id,
                'players/details/' . $data['players'][3]->id,
                'players/details/' . $data['players'][4]->id,
                'players/details/' . $data['players'][5]->id,
                'players/details/' . $data['players'][6]->id,
                'players/details/' . $data['players'][7]->id,
                'players/details/' . $data['players'][8]->id,
                'players/details/' . $data['players'][9]->id,
            ])
            ->dispatch('search-update', searchTerm: 'Filter') // simulate event
            ->assertSet('searchTerm', 'Filter')
            ->assertSeeHtmlInOrder([
                'players/details/' . $data['players'][0]->id,
                'players/details/' . $data['players'][2]->id,
                'players/details/' . $data['players'][4]->id,
                'players/details/' . $data['players'][6]->id,
                'players/details/' . $data['players'][8]->id,
            ]);
    }

    #[Test]
    public function it_updates_sort_id_when_sort_event_is_fired()
    {
        $data  = PlayerTestData::build(10);
        $names = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        foreach ($data['players'] as $key => $player) {
            $player->first_name = $names[$key];
            $player->save();
        }

        Livewire::test(ListView::class)
            ->set('sortId', 0) // starting value
            ->assertSeeHtmlInOrder([
                'players/details/' . $data['players'][0]->id,
                'players/details/' . $data['players'][1]->id,
                'players/details/' . $data['players'][2]->id,
                'players/details/' . $data['players'][3]->id,
                'players/details/' . $data['players'][4]->id,
                'players/details/' . $data['players'][5]->id,
                'players/details/' . $data['players'][6]->id,
                'players/details/' . $data['players'][7]->id,
                'players/details/' . $data['players'][8]->id,
                'players/details/' . $data['players'][9]->id,
            ])
            ->dispatch('sort-update', selected: 2) // Sort by name desc (Z-A)
            ->assertSet('sortId', 2)
            ->assertSeeHtmlInOrder([
                'players/details/' . $data['players'][9]->id,
                'players/details/' . $data['players'][8]->id,
                'players/details/' . $data['players'][7]->id,
                'players/details/' . $data['players'][6]->id,
                'players/details/' . $data['players'][5]->id,
                'players/details/' . $data['players'][4]->id,
                'players/details/' . $data['players'][3]->id,
                'players/details/' . $data['players'][2]->id,
                'players/details/' . $data['players'][1]->id,
                'players/details/' . $data['players'][0]->id,
            ]);
    }
}
