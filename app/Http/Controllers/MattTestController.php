<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Players\Player;
use App\Models\Players\Position;
use Illuminate\Http\Request;

class MattTestController extends Controller
{
    public function index(): void
    {
        $player = Player::first();
        $country = Country::first();
        //$position = Position::first(1);
        dd(
            $player,
            $player->position,
            $player->parentPosition,
            $player->nationality,
            $country->players,
            //$position
        );
    }
}
