<?php

namespace App\Models\Players\Acions;

use Exception;
use Illuminate\Support\Collection;

class BuildDbImportPlayerData
{
    public function __construct(public Collection $data) {}

    public static function fromCollection(Collection $players): BuildDbImportPlayerData
    {
        try {
            $dbPlayers = $players->map(function ($player) {
                return [
                    'external_player_id'   => $player['id'],
                    'first_name'           => $player['firstname'],
                    'last_name'            => $player['lastname'],
                    'date_of_birth'        => $player['date_of_birth'],
                    'gender'               => $player['gender'],
                    'parent_position_id'   => $player['type_id'], // sometimes sports monk position_id and detailed_position_id data are null, but type_id always has a value
                    'position_id'          => $player['detailed_position_id'] ?? $player['type_id'],
                    'nationality_id'       => $player['nationality_id'],
                    'image_path'           => $player['image_path'],
                ];
            });
        } catch (Exception $e) {
            info(['sports monk players data - build db player data error', $e->getMessage()]);

            return new BuildDbImportPlayerData(collect());
        }

        return new BuildDbImportPlayerData($dbPlayers);
    }
}
