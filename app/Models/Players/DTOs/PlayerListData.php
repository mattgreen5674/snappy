<?php

namespace App\Models\Players\DTOs;

use Illuminate\Support\Collection;

class PlayerListData
{
    public function __construct(
        public Collection $players,
        public int $lastPage,
    ) {}
}
