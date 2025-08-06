<?php

namespace App\Jobs\SportsMonk;

use App\Models\Players\Actions\BuildDbImportPlayerData;
use App\Models\Players\Player;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;

class SavePlayerData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Collection $players) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $dbImportData = BuildDbImportPlayerData::fromCollection($this->players)->data;

        if ($dbImportData->isNotEmpty()) {
            try {
                Player::upsert(
                    $dbImportData->toArray(),
                    uniqueBy: ['external_player_id'],
                    update: ['external_player_id', 'first_name', 'last_name', 'date_of_birth', 'gender', 'parent_position_id', 'position_id', 'nationality_id', 'image_path']
                );
            } catch (Exception $e) {
                info(['sports monk players data - db data import error', $e->getMessage()]);
            }
        }
    }
}
