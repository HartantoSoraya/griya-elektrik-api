<?php

namespace Tests\Feature;

use Tests\TestCase;

class BannerAPITest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->markTestSkipped('This test has not been implemented yet.');

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
