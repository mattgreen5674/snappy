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
        if (empty(request()->id)) {
            throw new Exception('Required player id missing');
            // \Sentry\captureMessage('Finding player details request without id');
        }

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
            info($e);
            // \Sentry\captureMessage('Finding player details by id failed');
            throw new Exception('Finding player details by id failed');
        }
    }
}
