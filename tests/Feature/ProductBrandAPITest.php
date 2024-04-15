<?php

namespace Tests\Feature;

use App\Models\ProductBrand;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductBrandAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    public function test_product_brand_api_call_create_with_auto_code_and_empty_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productBrand = ProductBrand::factory()->make([
            'code' => 'AUTO',
            'slug' => '',
        ])->toArray();

        $api = $this->json('POST', 'api/v1/product-brand', $productBrand);

        $api->assertSuccessful();

        $productBrand['code'] = $api['data']['code'];
        $productBrand['logo'] = $api['data']['logo'];
        $productBrand['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_brands', $productBrand
        );

        $this->assertTrue(Storage::disk('public')->exists($productBrand['logo']));
    }

    public function test_product_brand_api_call_create_with_random_code_and_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productBrand = ProductBrand::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-brand', $productBrand);

        $productBrand['logo'] = $api['data']['logo'];

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_brands', $productBrand
        );

        $this->assertTrue(Storage::disk('public')->exists($productBrand['logo']));
    }

    public function test_product_brand_api_call_create_with_existing_code_and_slug_expect_failure()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        ProductBrand::factory()->create(['code' => '1234567890']);

        $productBrand = ProductBrand::factory()->make(['code' => '1234567890'])->toArray();

        $api = $this->json('POST', 'api/v1/product-brand', $productBrand);

        $api->assertStatus(422);
    }

    public function test_product_brand_api_call_read_expect_collection()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productBrand = ProductBrand::factory()->count(3)->create();

        $api = $this->json('GET', 'api/v1/product-brand/read/any');

        $api->assertSuccessful();

        $api->assertJsonCount(3);

        foreach ($productBrand as $brand) {
            $this->assertDatabaseHas(
                'product_brands', $brand->toArray()
            );
        }
    }

    public function test_product_brand_api_call_read_by_slug_expect_collection()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productBrand = ProductBrand::factory()->create();

        $api = $this->json('GET', 'api/v1/product-brand/slug/'.$productBrand->slug);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_brands', $productBrand->toArray()
        );
    }

    public function test_product_brand_api_call_update_with_auto_code_and_empty_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productBrand = ProductBrand::factory()->create();

        $updatedProductBrand = ProductBrand::factory()->make(['code' => 'AUTO'])->toArray();

        $api = $this->json('POST', 'api/v1/product-brand/'.$productBrand->id, $updatedProductBrand);

        $api->assertSuccessful();

        $updatedProductBrand['code'] = $api['data']['code'];
        $updatedProductBrand['logo'] = $api['data']['logo'];
        $updatedProductBrand['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_brands', $updatedProductBrand
        );

        $this->assertTrue(Storage::disk('public')->exists($updatedProductBrand['logo']));
    }

    public function test_product_brand_api_call_update_with_random_code_and_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productBrand = ProductBrand::factory()->create();

        $updatedProductBrand = ProductBrand::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-brand/'.$productBrand->id, $updatedProductBrand);

        $api->assertSuccessful();

        $updatedProductBrand['logo'] = $api['data']['logo'];

        $this->assertDatabaseHas(
            'product_brands', $updatedProductBrand
        );

        $this->assertTrue(Storage::disk('public')->exists($updatedProductBrand['logo']));
    }

    public function test_product_brand_api_call_update_with_existing_code_in_different_product_brand_and_random_slug_expect_failure()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $existingProductBrand = ProductBrand::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $updatedProductBrand = $productBrand->toArray();
        $updatedProductBrand['code'] = $existingProductBrand->code;

        $api = $this->json('POST', 'api/v1/product-brand/'.$productBrand->id, $updatedProductBrand);

        $api->assertStatus(422);
    }

    public function test_product_brand_api_call_update_with_existing_code_in_same_product_brand_and_random_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productBrand = ProductBrand::factory()->create();

        $updatedProductBrand = ProductBrand::factory()->make(['code' => $productBrand->code])->toArray();

        $api = $this->json('POST', 'api/v1/product-brand/'.$productBrand->id, $updatedProductBrand);

        $api->assertSuccessful();

        $updatedProductBrand['logo'] = $api['data']['logo'];

        $this->assertDatabaseHas(
            'product_brands', $updatedProductBrand
        );

        $this->assertTrue(Storage::disk('public')->exists($updatedProductBrand['logo']));
    }

    public function test_product_brand_api_call_delete_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productBrand = ProductBrand::factory()->create();

        $api = $this->json('DELETE', 'api/v1/product-brand/'.$productBrand->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted(
            'product_brands', $productBrand->toArray()
        );
    }
}
