<?php

namespace App\Console\Commands;

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
        $postcodeZipSourceUrl  = 'https://parlvid.mysociety.org/os/ONSPD/2022-11.zip';
        $postCodeZipSourceFile = basename($postcodeZipSourceUrl);

        $response = Http::timeout(300)->get($postcodeZipSourceUrl);
        if ($response->successful()) {
            info('Successfully downloaded postcode zip');

            if (! Storage::exists('postcodes')) {
                info('Making postcodes directory as it did not exist');
                Storage::makeDirectory('postcodes');
            }

            $path = Storage::disk('local')->put('postcodes/' . $postCodeZipSourceFile, $response->body());
            if ($path) {
                info("File downloaded and stored successfully at: storage/app/private/postcodes/$postCodeZipSourceFile");
            } else {
                info('Failed to store the file.');
                // Log error with monitoring system
            }
        } else {
            info('Failed to download the file. Status Code: ' . $response->status());
            // Log error with monitoring system
        }

        $zip           = new ZipArchive;
        $zipFilePath   = Storage::path('postcodes/' . $postCodeZipSourceFile);
        $extractToPath = Storage::path('postcodes/' . Str::replace('.zip', '/', $postCodeZipSourceFile));

        // Open the zip file
        if ($zip->open($zipFilePath)) {
            // Extract the files to the specified directory
            $zip->extractTo($extractToPath);

            // Close the zip file
            $zip->close();

            info('Successfully extracted downloaded files from .zip');
        } else {
            info('Failed to extract downloaded files from .zip');
        }

        info('Finished postcode download and import');
    }
}
