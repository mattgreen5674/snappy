<?php

namespace App\Livewire\Players;

use App\Models\Players\Player;
use Exception;
use Livewire\Component;

class DetailView extends Component
{
    public Player $player;

    public function mount(): void
    {
        $this->getPlayer(request()->id);
    }

    public function render()
    {
        return view('livewire.players.detail-view');
    }

    public function getPlayer(int $id): void
    {
        try {
            $this->player = Player::findOrFail($id);
        } catch (Exception $e) {
            dd($e);
            info($e);
        }
    }
}
