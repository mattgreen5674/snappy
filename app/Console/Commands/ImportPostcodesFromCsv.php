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

        info('Remove postcodes directory after import');
        Storage::deleteDirectory('/postcodes');
        
        info('Finished postcode download and import');
    }
}
