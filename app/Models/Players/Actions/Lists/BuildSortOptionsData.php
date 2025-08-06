<?php

namespace App\Models\Players\Actions\Lists;

use Illuminate\Support\Collection;

class BuildSortOptionsData
{
    public Collection $options;

    public function __construct()
    {
        $this->build();
    }

    public static function get(): BuildSortOptionsData
    {
        return new BuildSortOptionsData;
    }

    public function build(): void
    {
        $this->options = collect([
            0 => 'None',
            1 => 'Name (A-Z)',
            2 => 'Name (Z-A)',
            3 => 'Nationality (A-Z)',
            4 => 'Nationality (Z-A)',
            5 => 'Position (A-Z)',
            6 => 'Position (Z-A)',
        ]);
    }
}
