<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ClientAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_client_api_call_store_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $client = Client::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/client', $client);

        $api->assertSuccessful();

        $client['logo'] = $api['data']['logo'];

        $this->assertDatabaseHas(
            'clients', $client
        );

        $this->assertTrue(Storage::disk('public')->exists($client['logo']));
    }

    public function test_client_api_call_read_expect_collection()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $clients = Client::factory()->count(5)->create();

        $api = $this->json('GET', 'api/v1/client/read/any');

        $api->assertSuccessful();

        foreach ($clients as $client) {
            $this->assertDatabaseHas(
                'clients', Arr::except($client->toArray(), 'logo')
            );
        }
    }

    public function test_client_api_call_show_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $client = Client::factory()->create();

        $api = $this->json('GET', 'api/v1/client/'.$client->id);

        $api->assertSuccessful();

        $client['logo'] = $api['data']['logo'];

        $this->assertDatabaseHas(
            'clients', $client->toArray()
        );
    }

    public function test_client_api_call_update_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $client = Client::factory()->create();

        $updatedClient = Client::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/client/'.$client->id, $updatedClient);

        $api->assertSuccessful();

        $updatedClient['logo'] = $api['data']['logo'];

        $this->assertDatabaseHas(
            'clients', $updatedClient
        );
    }

    public function test_client_api_call_delete_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $client = Client::factory()->create();

        $api = $this->json('DELETE', 'api/v1/client/'.$client->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted(
            'clients', $client->toArray()
        );
    }
}
