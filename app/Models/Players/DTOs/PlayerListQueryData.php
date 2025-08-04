<?php

namespace App\Models\Players\DTOs;

class PlayerListQueryData
{
    public function __construct(
        public string $searchTerm,
        public int $filterCountryId,
        public int $sortId,
        public int $currentPage,
        public int $limit
    ) {}
}
