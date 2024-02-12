<?php

namespace Tests\Feature;

use App\Models\ProductCategory;
use App\Models\User;
use Tests\TestCase;

class ProductCategoryAPITest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_product_category_api_call_create_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );
    }

    public function test_product_category_api_call_create_with_childs_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $categories = ProductCategory::factory()->getProductCategoryExample();

        // Create a parent category

        $productCategory = ProductCategory::factory()->setName($categories[0])->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );

        $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

        // Create a child category

        $productCategory = ProductCategory::factory()
            ->for($createdProductCategory, 'parent')
            ->setName($categories[1])
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );

        $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

        // Create a grandchild category

        $productCategory = ProductCategory::factory()
            ->for($createdProductCategory, 'parent')
            ->setName($categories[2])
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );
    }

    public function test_product_category_api_call_read_expect_collection()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->count(3)->create();

        $api = $this->json('GET', 'api/v1/product-categories');

        $api->assertSuccessful();

        $api->assertJsonCount(3);

        foreach ($productCategory as $category) {
            $this->assertDatabaseHas(
                'product_categories', $category->toArray()
            );
        }
    }

    public function test_product_category_api_call_read_root_categories_expect_collection()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        for ($i = 0; $i < 3; $i++) {
            $categories = ProductCategory::factory()->getProductCategoryExample();

            // Create a parent category

            $productCategory = ProductCategory::factory()->setName($categories[0])->make()->toArray();

            $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

            $api->assertSuccessful();

            $this->assertDatabaseHas(
                'product_categories', $productCategory
            );

            $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

            // Create a child category

            $productCategory = ProductCategory::factory()
                ->for($createdProductCategory, 'parent')
                ->setName($categories[1])
                ->make()->toArray();

            $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

            $api->assertSuccessful();

            $this->assertDatabaseHas(
                'product_categories', $productCategory
            );

            $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

            // Create a grandchild category

            $productCategory = ProductCategory::factory()
                ->for($createdProductCategory, 'parent')
                ->setName($categories[2])
                ->make()->toArray();

            $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

            $api->assertSuccessful();

            $this->assertDatabaseHas(
                'product_categories', $productCategory
            );
        }

        $api = $this->json('GET', 'api/v1/product-categories/root');

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );
    }

    public function test_product_category_api_call_read_leaf_categories_expect_collection()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $categories = ProductCategory::factory()->getProductCategoryExample();

        // Create a parent category

        $productCategory = ProductCategory::factory()->setName($categories[0])->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );

        $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

        // Create a child category

        $productCategory = ProductCategory::factory()
            ->for($createdProductCategory, 'parent')
            ->setName($categories[1])
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );

        $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

        // Create a grandchild category

        $productCategory = ProductCategory::factory()
            ->for($createdProductCategory, 'parent')
            ->setName($categories[2])
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );

        $api = $this->json('GET', 'api/v1/product-categories/leaf');

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $productCategory
        );
    }

    public function test_product_category_api_call_update_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $updatedProductCategory = ProductCategory::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-categories/'.$productCategory->id, $updatedProductCategory);

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories', $updatedProductCategory
        );
    }

    public function test_product_category_api_call_delete_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = ProductCategory::factory()->create();

        $api = $this->json('DELETE', 'api/v1/product-categories/'.$productCategory->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted(
            'product_categories', $productCategory->toArray()
        );
    }
}
