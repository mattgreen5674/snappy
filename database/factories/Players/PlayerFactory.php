<?php

namespace Database\Factories\Players;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Players>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomPosition    = Arr::random([24, 25, 26, 27]);
        $randomNationality = Arr::random([455, 462, 515, 1161]); // Ireland, England, Wales, Scotland

        return [
            'external_player_id'   => fake()->numberBetween(1, 5000), // Hopefully doesn't cause conflict
            'first_name'           => fake()->firstName(),
            'last_name'            => fake()->lastName(),
            'date_of_birth'        => fake()->date(),
            'gender'               => 'male',
            'parent_position_id'   => $randomPosition,
            'position_id'          => $randomPosition,
            'nationality_id'       => $randomNationality,
            'image_path'           => fake()->url(),
        ];
    }
}
