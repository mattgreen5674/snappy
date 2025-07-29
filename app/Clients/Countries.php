<?php

// https://docs.sportmonks.com/football/core-api/endpoints/countries/get-all-countries

namespace App\Clients;

use Exception;
use Symfony\Component\HttpFoundation\Response as HttpStatuses;

class Countries extends SportsMonk
{
    public string $endPoint = 'core/countries';

    /**
     * Get a list of players.
     *
     * @param  int  $nextId  - Enables you to search for records with id higher than the one supplied
     * @param  int  $perPage  - The number of records to be returned: Allowed values are 25 - 50 or 1000
     */
    public function list(int $nextId = 0, int $perPage = 1000): array
    {
        $this->buildQueryParameters($nextId, $perPage);
        $response = $this->client->get($this->endPoint, $this->parameters);

        if ($response->status() !== HttpStatuses::HTTP_OK) {
            $errMsg = 'Sports Monk API getting countries list failed';
            info([$errMsg, $response->status(), $response->body()]);
            throw new Exception($errMsg);
        }

        // At this point it doesn't look like we need any of the other data, but it may prove better to return everything.
        return [
            'data'     => $response->json('data'),
            'meta'     => array_merge(
                $response->json('subscription.0.meta'), // would need to understand subscriptions better to ensure key 0 is consistent.
                ['has_more' => $response->json('pagination.has_more')], // lets us know if there are more records to be retrieved.
            ),
        ];
    }
}
