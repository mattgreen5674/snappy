<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Players>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_country_id'  => fake()->numberBetween(1, 250), // Hopefully doesn't cause conflict
            'name'                 => fake()->country(),
            'fifa_name'            => fake()->countryCode(),
            'image_path'           => fake()->url(),
        ];
    }
}
