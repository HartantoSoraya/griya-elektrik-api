<?php

namespace Tests\Feature;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BannerAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_banner_api_call_create_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $banner = Banner::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/banners', $banner);

        $api->assertSuccessful();

        $banner['image'] = $api['data']['image'];

        $this->assertDatabaseHas('banners', $banner);

        $this->assertTrue(Storage::disk('public')->exists($banner['image']));
    }

    public function test_banner_api_call_read_expect_collection()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $banners = Banner::factory()->count(3)->create();

        $api = $this->json('GET', 'api/v1/banners');

        $api->assertSuccessful();

        $api->assertJsonCount(3);

        foreach ($banners as $banner) {
            $this->assertDatabaseHas('banners', $banner->toArray());
        }
    }

    public function test_banner_api_call_update_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $banner = Banner::factory()->create();

        $newBanner = Banner::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/banners/'.$banner->id, $newBanner);

        $api->assertSuccessful();

        $newBanner['image'] = $api['data']['image'];

        $this->assertDatabaseHas('banners', $newBanner);

        $this->assertTrue(Storage::disk('public')->exists($newBanner['image']));
    }

    public function test_banner_api_call_delete_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $banner = Banner::factory()->create();

        $api = $this->json('DELETE', 'api/v1/banners/'.$banner->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted('banners', $banner->toArray());

        $this->assertFalse(Storage::disk('public')->exists($banner->image));
    }
}
