<?php

namespace App\Console\Commands;

use App\Jobs\ImportPostcodes;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ImportPostcodesFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-postcodes-from-csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download and import post code data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        info('Starting postcode download and import');
        $postcodeZipUrl      = 'https://parlvid.mysociety.org/os/ONSPD/2022-11.zip'; // How do we know about and manage file changes?
        $postCodeZipFile     = basename($postcodeZipUrl);
        $postCodeZipFilePath = 'postcodes/' . $postCodeZipFile;

        $response = Http::timeout(300)->get($postcodeZipUrl);
        if ($response->successful()) {
            info('Successfully downloaded postcode zip');

            if (! Storage::exists('postcodes')) {
                info('Making postcodes directory as it did not exist');
                Storage::makeDirectory('postcodes');
            }

            $path = Storage::disk('local')->put($postCodeZipFilePath, $response->body());
            if ($path) {
                info("File downloaded and stored successfully at: storage/app/private/$postCodeZipFilePath");
            } else {
                info('Failed to store the file.');
                // Log error with monitoring system
            }
        } else {
            info('Failed to download the file. Status Code: ' . $response->status());
            // Log error with monitoring system
        }

        $zip           = new ZipArchive;
        $zipFilePath   = Storage::path($postCodeZipFilePath);
        $extractToPath = Storage::path(Str::replace('.zip', '/', $postCodeZipFilePath));

        // Open the zip file
        if ($zip->open($zipFilePath)) {
            $zip->extractTo($extractToPath);
            $zip->close();
            info('Successfully extracted downloaded files from .zip');
        } else {
            info('Failed to extract downloaded files from .zip');
        }

        // Extract the postcodes and batch them into jobs for processing into the DB
        $filepath = $extractToPath . '/Data/ONSPD_NOV_2022_UK.csv'; // Again how are we expecting to know about and manage file changes?
        $file = fopen($filepath, 'r');
        if ($file !== false) {
            $chunk = collect();
            
            // Skip the first line (header row)
            fgetcsv($file);  // This reads and discards the first line

            info ('Started batching postcode data into jobs');
            while ($line = fgetcsv($file, 1000)) {

                $chunk->push([
                    'postcode'  => $line[0],
                    'latitude'  => $line[42],
                    'longitude' => $line[43],
                ]);

                if ($chunk->count() == 10000) {
                    ImportPostcodes::dispatch($chunk)->delay(now()->addMinutes(10));
                    $chunk = collect();
                }
            }

            // Process the final rows when they total less than 10,000 
            if ($chunk->isNotEmpty()) {
                ImportPostcodes::dispatch($chunk)->delay(now()->addMinutes(10));
            }

            info('Finished batching postcode data into jobs');
        } else {
            info('Failed to open downloaded postcodes file');
            // Log error with monitoring system
        }

        info('Remove postcodes directory after import');
        Storage::deleteDirectory('/postcodes');
        
        info('Finished postcode download and import');
    }
}
