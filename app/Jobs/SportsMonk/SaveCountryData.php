<?php

namespace App\Jobs\SportsMonk;

use App\Models\Countries\Acions\BuildDbImportCountryData;
use App\Models\Countries\Country;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;

class SaveCountryData implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public Collection $countries) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $dbImportData = BuildDbImportCountryData::fromCollection($this->countries)->data;

        if ($dbImportData->isNotEmpty()) {
            try {
                Country::upsert(
                    $dbImportData->toArray(),
                    uniqueBy: ['external_country_id'],
                    update: ['external_country_id', 'name', 'fifa_name', 'image_path']
                );
            } catch (Exception $e) {
                info(['sports monk import countries data - db data import error', $e->getMessage()]);
            }
        }
    }
}
