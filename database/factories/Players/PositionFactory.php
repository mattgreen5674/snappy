<?php

namespace Database\Factories\Players;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Players>
 */
class PositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomPosition = Arr::random([24, 25, 26, 27]);

        $positions = [
            24 => 'Goalkeeper',
            25 => 'Defender',
            26 => 'Midfielder',
            27 => 'Attacker',
        ];

        return [
            'external_position_id' => $randomPosition,
            'name'                 => $positions[$randomPosition],
        ];
    }
}
