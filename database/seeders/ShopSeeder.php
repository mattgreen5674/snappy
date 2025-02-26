<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $postCodes = [
            'BH1 1BP' => ['lat' => 50.726731, 'long' => -1.873747], // 1.9 miles
            'BH1 2ES' => ['lat' => 50.71932, 'long' => -1.870985], // 2.1 miles
            'BH1 3ES' => ['lat' => 50.721636, 'long' => -1.859065], // 1.6 miles
            'BH1 4ES' => ['lat' => 50.729846, 'long' => -1.844589], // 0.8 miles
            'BH1 4FF' => ['lat' => 50.728927, 'long' => -1.838406], // 0.7 miles
            'BH1 4HG' => ['lat' => 50.726655, 'long' => -1.845577], // 1 mile
            'BH1 4RD' => ['lat' => 50.728536, 'long' => -1.853859], // 0.2 miles
            'BH1 4NP' => ['lat' => 50.731001, 'long' => -1.842635], // 0.6 miles
            'BH1 4NT' => ['lat' => 50.734163, 'long' => -1.845524], // 0.2 miles
        ];

        // Base = BH1 4NX (50.733339, -1.847595)

        foreach ($postCodes as $postCode) {
            $lat  = $postCode['lat'];
            $long = $postCode['long'];

            // All open shops who will delivery within 1000 metres
            Shop::factory()->create([
                'latitude'    => $lat,
                'longitude'   => $long,
            ]);
        }
    }
}
