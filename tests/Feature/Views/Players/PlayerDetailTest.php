<?php

namespace Tests\Feature\Views\Players;

use App\Livewire\Players\DetailView;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Tests\TestData\PlayerTestData;

class PlayerDetailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_fails_to_display_when_player_id_not_supplied(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Required player id missing');

        $user = User::factory()->create(['name' => 'Test Testing']);

        $response = Livewire::withQueryParams(['id' => null])
            ->actingAs($user)
            ->test(DetailView::class);

        $response->assertStatus(404);
    }

    #[Test]
    public function it_fails_to_display_when_player_id_does_not_exist(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Finding player details by id failed');

        $user = User::factory()->create(['name' => 'Test Testing']);

        $response = Livewire::withQueryParams(['id' => '9999'])
            ->actingAs($user)
            ->test(DetailView::class);

        $response->assertStatus(404);
    }

    #[Test]
    public function it_displays_player_details_successfully(): void
    {
        $data = PlayerTestData::build();
        $user = User::factory()->create(['name' => 'Test Testing']);

        Livewire::withQueryParams(['id' => $data['player']->id])
            ->actingAs($user)
            ->test(DetailView::class)
            ->assertSeeText('Player:')
            ->assertSeeText($data['player']->full_name)
            ->assertSeeHtmlInOrder(['<img', 'src="' . $data['player']->image_path . '"', 'alt="' . $data['player']->full_name . ' image"'])
            ->assertSeeInOrder([
                'First Name:',
                $data['player']->first_name,
                'Last Name:',
                $data['player']->last_name,
                'DOB:',
                Carbon::parse($data['player']->date_of_birth)->format('d-m-Y'),
                'Gender:',
                ucwords($data['player']->gender),
                'Nationality:',
                $data['country']->name,
                'Player Type:',
                $data['parentPosition']->name,
                'Position:',
                $data['position']->name,
            ]);
    }
}
