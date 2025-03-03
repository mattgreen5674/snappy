<?php

namespace App\Jobs;

use App\Models\PostCode;
use App\Rules\PostCode as PostCodeRule;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ImportPostcodes implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Collection $postcodesData
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->postcodesData as $postcodeData) {
            $validator = Validator::make(
                $postcodeData,
                [
                    'postcode'  => ['required', 'string', 'min:7', 'max:8', new PostCodeRule],
                    'latitude'  => ['required', 'numeric', 'between:-90,90'],
                    'longitude' => ['required', 'numeric', 'between:-180,180'],
                ]
            );

            if ($validator->fails()) {
                info(['Postcode data import validation error', $postcodeData, $validator->errors()]);
                // Log error with monitoring system
            } else {

                try {
                    $postcode = PostCode::where('post_code', $postcodeData['postcode'])->first();

                    if ($postcode) {
                        $postcode->latitude  = $postcodeData['latitude'];
                        $postcode->longitude = $postcodeData['longitude'];
                    } else {
                        $postcode = new Postcode;
                        $postcode->post_code = $postcodeData['postcode'];
                        $postcode->latitude  = $postcodeData['latitude'];
                        $postcode->longitude = $postcodeData['longitude'];
                    }

                    $postcode->save();

                } catch (Exception $e) {
                    info($e);
                    // Log error with monitoring system
                }
            }
        }
    }
}
