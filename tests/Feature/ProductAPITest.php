<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\User;
use Tests\TestCase;

class ProductAPITest extends TestCase
{
    public function test_product_api_call_create_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $product = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/products', $product);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'products', $product
        );
    }

    public function test_product_api_call_create_with_existing_code_expect_fail()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $product = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->create(['code' => 'test']);

        $product = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->make(['code' => 'test'])->toArray();

        $api = $this->json('POST', 'api/v1/products', $product);

        $api->assertStatus(422);
    }

    public function test_product_api_call_read_expect_collection()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $product = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->count(3)
            ->create();

        $api = $this->json('GET', 'api/v1/products');

        $api->assertSuccessful();

        $api->assertJsonCount(3);

        foreach ($product as $item) {
            $this->assertDatabaseHas(
                'products', $item->toArray()
            );
        }
    }

    public function test_product_api_call_update_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $product = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->create();

        $productCategory = ProductCategory::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $productUpdate = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/products/'.$product->id, $productUpdate);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'products', $productUpdate
        );
    }

    public function test_product_api_call_update_with_existing_code_in_same_product_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $product = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->create();

        $productUpdate = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->make(['code' => $product->code])->toArray();

        $api = $this->json('POST', 'api/v1/products/'.$product->id, $productUpdate);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'products', $productUpdate
        );
    }

    public function test_product_api_call_update_with_existing_code_in_different_product_expect_fail()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $existingProduct = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->create();

        $newProduct = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->create();

        $productUpdate = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->make(['code' => $existingProduct->code])->toArray();

        $api = $this->json('POST', 'api/v1/products/'.$newProduct->id, $productUpdate);

        $api->assertStatus(422);
    }

    public function test_product_api_call_delete_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $productBrand = ProductBrand::factory()->create();

        $product = Product::factory()
            ->for($productCategory, 'category')
            ->for($productBrand, 'brand')
            ->create();

        $api = $this->json('DELETE', 'api/v1/products/'.$product->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted(
            'products', $product->toArray()
        );
    }
}
