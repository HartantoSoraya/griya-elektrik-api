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
        $user = User::factory()->create();

        $this->actingAs($user);

        $banner = Banner::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/banner', $banner);

        $api->assertSuccessful();

        $banner['desktop_image'] = $api['data']['desktop_image'];
        $banner['mobile_image'] = $api['data']['mobile_image'];

        $this->assertDatabaseHas('banners', $banner);

        $this->assertTrue(Storage::disk('public')->exists($banner['desktop_image']));
        $this->assertTrue(Storage::disk('public')->exists($banner['mobile_image']));
    }

    public function test_banner_api_call_read_expect_collection()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $banners = Banner::factory()->count(3)->create();

        $api = $this->json('GET', 'api/v1/banner/read/any');

        $api->assertSuccessful();

        $api->assertJsonCount(3);

        foreach ($banners as $banner) {
            $this->assertDatabaseHas('banners', $banner->toArray());
        }
    }

    public function test_banner_api_call_update_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $banner = Banner::factory()->create();

        $newBanner = Banner::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/banner/'.$banner->id, $newBanner);

        $api->assertSuccessful();

        $newBanner['desktop_image'] = $api['data']['desktop_image'];
        $newBanner['mobile_image'] = $api['data']['mobile_image'];

        $this->assertDatabaseHas('banners', $newBanner);

        $this->assertTrue(Storage::disk('public')->exists($newBanner['desktop_image']));
        $this->assertTrue(Storage::disk('public')->exists($newBanner['mobile_image']));
    }

    public function test_banner_api_call_delete_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $banner = Banner::factory()->create();

        $api = $this->json('DELETE', 'api/v1/banner/'.$banner->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted('banners', $banner->toArray());

        $this->assertFalse(Storage::disk('public')->exists($banner->desktop_image));
        $this->assertFalse(Storage::disk('public')->exists($banner->mobile_image));
    }
}
