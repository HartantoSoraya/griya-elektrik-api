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
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productBrand = ProductBrand::factory()->make([
            'code' => 'AUTO',
            'slug' => '',
        ])->toArray();

        $api = $this->json('POST', 'api/v1/product-brands', $productBrand);

        $api->assertSuccessful();

        $productBrand['code'] = $api['data']['code'];
        $productBrand['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_brands', $productBrand
        );
    }

    public function test_product_brand_api_call_create_with_random_code_and_slug_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productBrand = ProductBrand::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-brands', $productBrand);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_brands', $productBrand
        );
    }

    public function test_product_brand_api_call_create_with_existing_code_and_slug_expect_failure()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        ProductBrand::factory()->create(['code' => '1234567890']);

        $productBrand = ProductBrand::factory()->make(['code' => '1234567890'])->toArray();

        $api = $this->json('POST', 'api/v1/product-brands', $productBrand);

        $api->assertStatus(422);
    }

    public function test_product_brand_api_call_read_expect_collection()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productBrand = ProductBrand::factory()->count(3)->create();

        $api = $this->json('GET', 'api/v1/product-brands');

        $api->assertSuccessful();

        $api->assertJsonCount(3);

        foreach ($productBrand as $brand) {
            $this->assertDatabaseHas(
                'product_brands', $brand->toArray()
            );
        }
    }

    public function test_product_brand_api_call_update_with_auto_code_and_empty_slug_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productBrand = ProductBrand::factory()->create();

        $updatedProductBrand = ProductBrand::factory()->make(['code' => 'AUTO'])->toArray();

        $api = $this->json('POST', 'api/v1/product-brands/'.$productBrand->id, $updatedProductBrand);

        $api->assertSuccessful();

        $updatedProductBrand['code'] = $api['data']['code'];
        $updatedProductBrand['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_brands', $updatedProductBrand
        );
    }

    public function test_product_brand_api_call_update_with_random_code_and_slug_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productBrand = ProductBrand::factory()->create();

        $updatedProductBrand = ProductBrand::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-brands/'.$productBrand->id, $updatedProductBrand);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_brands', $updatedProductBrand
        );
    }

    public function test_product_brand_api_call_update_with_existing_code_and_random_slug_expect_failure()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $existingProductBrand = ProductBrand::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $updatedProductBrand = $productBrand->toArray();
        $updatedProductBrand['code'] = $existingProductBrand->code;

        $api = $this->json('POST', 'api/v1/product-brands/'.$productBrand->id, $updatedProductBrand);

        $api->assertStatus(422);
    }

    public function test_product_brand_api_call_delete_expect_successful()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productBrand = ProductBrand::factory()->create();

        $api = $this->json('DELETE', 'api/v1/product-brands/'.$productBrand->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted(
            'product_brands', $productBrand->toArray()
        );
    }
}
