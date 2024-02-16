<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WebConfiguration;
use Tests\TestCase;

class WebConfigurationAPITest extends TestCase
{
    public function test_web_configuration_api_call_read_expect_collection()
    {
        $this->markTestSkipped('puyeng');

        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        WebConfiguration::factory()->create();

        $api = $this->json('GET', 'api/v1/web-configuration');

        $api->assertJsonStructure([
            'data' => [
                'title',
                'description',
                'logo',
            ],
        ]);
    }

    public function test_web_configuration_api_call_update_expect_successfull()
    {
        $this->markTestSkipped('puyeng');

        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $webConfiguration = WebConfiguration::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/web-configuration', $webConfiguration);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'web_configurations', $webConfiguration
        );
    }
}
