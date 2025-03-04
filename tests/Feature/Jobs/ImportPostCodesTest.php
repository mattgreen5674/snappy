<?php

namespace Tests\Feature\Jobs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImportPostCodesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Checks no post codes are created when no data provided
     */
    #[Test]
    public function fails_to_create_a_post_code_when_no_data_provided(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks validation rejects post code when it is not a string
     */
    #[Test]
    public function fails_to_create_a_post_code_when_post_code_is_not_a_string(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks validation rejects post code when it is too short
     */
    #[Test]
    public function fails_to_create_post_code_when_post_code_is_too_short(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks validation rejects post code when it is too long
     */
    #[Test]
    public function fails_to_create_post_code_when_post_code_is_too_long(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks validation rejects post code when it is not in correct format
     */
    #[Test]
    public function fails_to_create_post_code_when_post_code_is_not_in_the_correct_format(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks validation rejects request when post code latitude is not numeric value
     */
    #[Test]
    public function fails_to_create_post_code_when_new_post_code_latitude_is_not_numeric_value(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks alidation rejects request when post code latitude not between min and max values
     */
    #[Test]
    public function fails_to_create_post_code_when_new_post_code_latitude_not_betweeen_min_and_max_values(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks alidation rejects request when post Code longitude is not numeric value
     */
    #[Test]
    public function fails_to_create_post_code_when_new_post_code_longitude_is_not_numeric_value(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks validation rejects request when post code longitude not between min and max values
     */
    #[Test]
    public function fails_to_create_post_code_when_new_post_code_longitude_not_betweeen_min_and_max_values(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks new post code is created successfully and the returned data is as expected 
     */
    #[Test]
    public function successfully_creates_a_new_post_code_record(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }

    /**
     * Checks existing post code is updated successfully and the returned data is as expected 
     */
    #[Test]
    public function successfully_updates_an_existing_post_code_record(): void
    {
        // Todo write test!

        $this->assertTrue(true);
    }
}
