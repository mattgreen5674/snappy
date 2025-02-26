<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PostCodes>
 */
class PostCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_code' => fake()->postcode(),
            'latitude'  => fake()->latitude(),
            'longitude' => fake()->longitude(),
        ];
    }
}
