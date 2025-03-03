<?php

namespace Tests\Feature\API\Shops;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public string $url = 'http://localhost/api/shops';

    /**
     * Checks new shop validation rejects request when no data provided
     */
    #[Test]
    public function fails_to_create_a_shop_when_no_new_shop_data_provided(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop name is not a string
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_name_is_not_a_string(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop name is too short
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_name_is_too_short(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop name is too long
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_name_is_too_long(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop name already exists in DB
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_name_already_in_database(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop latitude is not numeric value
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_latitude_is_not_numeric_value(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop latitude not between min and max values
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_latitude_not_betweeen_min_and_max_values(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop longitude is not numeric value
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_longitude_is_not_numeric_value(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop longitude not between min and max values
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_longitude_not_betweeen_min_and_max_values(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop status_is_not_a_string
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_status_is_not_a_string(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop status is not an allowed value
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_status_is_not_an_allowed_value(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop type_is_not_a_string
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_type_is_not_a_string(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop type is not an allowed value
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_type_is_not_an_allowed_value(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop max delivery distance is not an integer
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_max_delivery_distance_is_not_a_integer(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop max delivery distance is below the maximum allowed value 
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_max_delivery_distance_is_below_the_maximum_allowed_value(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop validation rejects request when shop max delivery distance is above the maximum allowed value 
     */
    #[Test]
    public function fails_to_create_a_shop_when_new_shop_max_delivery_distance_is_above_the_maximum_allowed_value(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new shop is created successfully and the returned data is as expected 
     */
    #[Test]
    public function successfully_creates_a_new_shop_record(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }
}
