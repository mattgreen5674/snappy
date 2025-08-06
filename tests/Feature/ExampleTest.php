<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    #[Test]
    public function the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');
    }
}
