<?php

namespace Tests\Feature\Livewire\Helpers\Lists;

use App\Livewire\Helpers\Lists\Pagination;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PaginationTest extends TestCase
{
    #[Test]
    public function it_shows_all_pages_when_last_page_is_five_or_less()
    {
        Livewire::test(Pagination::class, [
            'currentPage' => 1,
            'lastPage' => 5,
        ])
        ->call('updatePagination')
        ->assertSet('pagination', [1, 2, 3, 4, 5]);
    }

    #[Test]
    public function it_shows_near_beginning_pagination_when_on_first_three_pages()
    {
        Livewire::test(Pagination::class, [
            'currentPage' => 2,
            'lastPage' => 10,
        ])
        ->call('updatePagination')
        ->assertSet('pagination', [1, 2, 3, 4, 'dots', 10]);
    }

    #[Test]
    public function it_shows_near_end_pagination_when_on_last_three_pages()
    {
        Livewire::test(Pagination::class, [
            'currentPage' => 9,
            'lastPage' => 10,
        ])
        ->call('updatePagination')
        ->assertSet('pagination', [1, 'dots', 7, 8, 9, 10]);
    }

    #[Test]
    public function it_shows_middle_range_pagination_when_in_between()
    {
        Livewire::test(Pagination::class, [
            'currentPage' => 5,
            'lastPage' => 10,
        ])
        ->call('updatePagination')
        ->assertSet('pagination', [1, 'dots', 4, 5, 6, 'dots', 10]);
    }

    #[Test]
    public function it_dispatches_pagination_update_event()
    {
        Livewire::test(Pagination::class, [
            'currentPage' => 1,
            'lastPage' => 5,
        ])
        ->call('update', 3)
        ->assertDispatched('pagination-update', newPage: 3);
    }
}
