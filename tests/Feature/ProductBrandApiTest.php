<?php

namespace Tests\Feature;

use App\Models\ProductBrand;
use App\Models\User;
use Tests\TestCase;

class ProductBrandApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_product_brand_api_call_create_expect_successfull()
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

    public function test_product_brand_api_call_update_expect_successfull()
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

    public function test_product_brand_api_call_delete_expect_successfull()
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
