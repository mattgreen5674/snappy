<?php

namespace App\Clients;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class SportsMonk
{
    public PendingRequest $client;
    public array $parameters;

    public function __construct()
    {
        try {
            $apiKey  = config('sportsmonk.api.key');
            $baseUrl = config('sportsmonk.api.base_url');
            if (empty($apiKey) || empty($baseUrl)) {
                throw new Exception('Sports Monk API missing client details');
            }

            $this->parameters = ['api_token' => $apiKey];
            $this->client     = Http::timeout(10)
                ->baseUrl($baseUrl)
                ->acceptJson();

        } catch (Exception $e) {
            info($e);
            // \Sentry\captureMessage('Sports Monk API connection failed');
            throw new Exception('Sports Monk API connection failed');
        }
    }

    public function buildQueryParameters(int $id = 0, $perPage = 1000): void
    {
        if ($id != 0) {
            $this->parameters = array_merge($this->parameters, ['idAfter' => $id]);
        }

        // Get the maximum number of records allowed by api returned
        if ($perPage == 1000) {
            $this->parameters = array_merge($this->parameters, ['filters' => 'populate']);
        }

        // Default (July 2025) records return = 25, the maximum we can request using per page is 50.
        if ($perPage <= 50) {
            $this->parameters = array_merge($this->parameters, ['per_page' => $perPage]);
        }
    }
}
