<?php

namespace Tests\Feature\API\Shops;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class NearToPostCodeTest extends TestCase
{
    use RefreshDatabase;

    public string $url = 'http://localhost/api/shops/near-to-postcode';

    /**
     * Checks find shops near to postcode validation rejects request when no data provided
     */
    #[Test]
    public function fails_to_find_shops_when_no_data_provide(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks find shops near to postcode validation rejects post code is not a string
     */
    #[Test]
    public function fails_to_find_shops_when_post_code_is_not_a_string(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks find shops near to postcode validation rejects post code is too short
     */
    #[Test]
    public function fails_to_find_shops_when_post_code_is_too_short(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks find shops near to postcode validation rejects post code is too long
     */
    #[Test]
    public function fails_to_find_shops_when_post_code_is_too_long(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks find shops near to postcode validation rejects post code is not in correct format
     */
    #[Test]
    public function fails_to_find_shops_when_post_code_is_not_in_the_correct_format(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks find shops near to postcode validation rejects distance is not an integer - it is a string
     */
    #[Test]
    public function fails_to_find_shops_when_distance_is_not_an_integer_is_string(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks find shops near to postcode validation rejects distance is not an integer - it is a decimal
     */
    #[Test]
    public function fails_to_find_shops_when_distance_is_not_an_integer_is_decimal(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks find shops near to postcode fails when no post code found
     */
    #[Test]
    public function fails_to_find_shops_when_no_post_code_found(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks a list of shops near to post code are returned which are within a 1000 metres of a given post code 
     */
    #[Test]
    public function successfully_finds_shops_within_default_distance_of_post_code(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks a list of shops near to post code are returned which are within custom distance of 500 metres of a given post code 
     */
    #[Test]
    public function successfully_finds_shops_within_custom_distance_of_post_code(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks a list of shops near to post code are limited to 100 records
     */
    #[Test]
    public function successfully_finds_shops_within_default_distance_of_post_code_but_limited_to_first_100_records(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks a list of shops near to post code ordered from nearest to the furthest away
     */
    #[Test]
    public function successfully_finds_shops_within_default_distance_of_post_code_and_results_are_ordered_from_nearest_to_furthest(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }
}
