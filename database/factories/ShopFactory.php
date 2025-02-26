<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lat  = fake()->numberBetween(-90, 90);
        $long = fake()->numberBetween(-180, 180);
        return [
            'name'                   => fake()->company() ,
            'latitude'               => $lat,
            'longitude'              => $long,
            'status'                 => config('snappy.app.default.model.shop.status.open'),
            'type'                   => config('snappy.app.default.model.shop.type.shop'),
            'max_delivery_distance' => 1000, // metres
        ];
    }
}
