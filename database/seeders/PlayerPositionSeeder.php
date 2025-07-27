<?php

namespace Database\Seeders;

use App\Models\Players\Position;
use Illuminate\Database\Seeder;

class PlayerPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Position::factory()->count(22)->sequence(
            // General Positions
            ['external_position_id' => 24, 'name' => 'Goalkeeper'],
            ['external_position_id' => 25, 'name' => 'Defender'],
            ['external_position_id' => 26, 'name' => 'Midfielder'],
            ['external_position_id' => 27, 'name' => 'Attacker'],
            ['external_position_id' => 28, 'name' => 'Unknown'],

            // Detailed Positions
            ['external_position_id' => 148, 'name' => 'Centre Back'],
            ['external_position_id' => 149, 'name' => 'Defensive Midfield'],
            ['external_position_id' => 150, 'name' => 'Attacking Midfield'],
            ['external_position_id' => 151, 'name' => 'Centre Forward'],
            ['external_position_id' => 152, 'name' => 'Left Wing'],
            ['external_position_id' => 153, 'name' => 'Central Midfield'],
            ['external_position_id' => 154, 'name' => 'Right Back'],
            ['external_position_id' => 155, 'name' => 'Left Back'],
            ['external_position_id' => 156, 'name' => 'Right Wing'],
            ['external_position_id' => 157, 'name' => 'Left Midfield'],
            ['external_position_id' => 158, 'name' => 'Right Midfield'],
            ['external_position_id' => 163, 'name' => 'Secondary Striker'],
            ['external_position_id' => 221, 'name' => 'Coach'],
            ['external_position_id' => 226, 'name' => 'Assistant Coach'],
            ['external_position_id' => 227, 'name' => 'Goalkeeping Coach'],
            ['external_position_id' => 228, 'name' => 'Forward Coach'],
            ['external_position_id' => 560, 'name' => 'Caretaker Manager'],
            // Weirdly data doesn't have a manager!?! 
        )->create();
    }
}
