<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductCategoryAPITest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
    }

    /**
     * A basic feature test example.
     */
    public function test_product_category_api_call_create_with_auto_code_and_empty_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productCategory = ProductCategory::factory()->make([
            'code' => 'AUTO',
            'slug' => '',
        ])->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['code'] = $api['data']['code'];
        $productCategory['image'] = $api['data']['image'];
        $productCategory['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );

        $this->assertTrue(Storage::disk('public')->exists($productCategory['image']));
    }

    public function test_product_category_api_call_create_with_random_code_and_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productCategory = ProductCategory::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['image'] = $api['data']['image'];

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );

        $this->assertTrue(Storage::disk('public')->exists($productCategory['image']));
    }

    public function test_product_category_api_call_create_with_random_code_and_slug_and_childs_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $categories = ProductCategory::factory()->getProductCategoryExample();

        // Create a parent category

        $productCategory = ProductCategory::factory()->setName($categories[0])->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['image'] = $api['data']['image'];

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );

        $this->assertTrue(Storage::disk('public')->exists($productCategory['image']));

        $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

        // Create a child category

        $productCategory = ProductCategory::factory()
            ->for($createdProductCategory, 'parent')
            ->setName($categories[1])
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['image'] = $api['data']['image'];

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );

        $this->assertTrue(Storage::disk('public')->exists($productCategory['image']));

        $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

        // Create a grandchild category

        $productCategory = ProductCategory::factory()
            ->for($createdProductCategory, 'parent')
            ->setName($categories[2])
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['image'] = $api['data']['image'];

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );

        $this->assertTrue(Storage::disk('public')->exists($productCategory['image']));
    }

    public function test_product_category_api_call_create_with_random_code_and_slug_and_parent_has_been_used_on_products_expect_error()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $parentCategory = ProductCategory::factory()->create();

        $brand = ProductBrand::factory()->create();

        Product::factory()->for($parentCategory, 'category')->for($brand, 'brand')->create();

        $productCategory = ProductCategory::factory()
            ->for($parentCategory, 'parent')
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertStatus(422);
    }

    public function test_product_category_api_call_read_expect_collection()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productCategories = ProductCategory::factory()->count(3)->create();

        $api = $this->json('GET', 'api/v1/product-category/read/any');

        $api->assertSuccessful();

        $api->assertJsonCount(3);

        foreach ($productCategories as $category) {
            $this->assertDatabaseHas(
                'product_categories',
                $category->toArray()
            );
        }
    }

    public function test_product_category_api_call_read_root_categories_expect_collection()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        for ($i = 0; $i < 3; $i++) {
            $categories = ProductCategory::factory()->getProductCategoryExample();

            // Create a parent category

            $productCategory = ProductCategory::factory()->setName($categories[0])->make()->toArray();

            $api = $this->json('POST', 'api/v1/product-category', $productCategory);

            $api->assertSuccessful();

            $productCategory['image'] = $api['data']['image'];
            $productCategory['slug'] = $api['data']['slug'];

            $this->assertDatabaseHas(
                'product_categories',
                $productCategory
            );

            $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

            // Create a child category

            $productCategory = ProductCategory::factory()
                ->for($createdProductCategory, 'parent')
                ->setName($categories[1])
                ->make()->toArray();

            $api = $this->json('POST', 'api/v1/product-category', $productCategory);

            $api->assertSuccessful();

            $productCategory['image'] = $api['data']['image'];
            $productCategory['slug'] = $api['data']['slug'];

            $this->assertDatabaseHas(
                'product_categories',
                $productCategory
            );

            $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

            // Create a grandchild category

            $productCategory = ProductCategory::factory()
                ->for($createdProductCategory, 'parent')
                ->setName($categories[2])
                ->make()->toArray();

            $api = $this->json('POST', 'api/v1/product-category', $productCategory);

            $api->assertSuccessful();

            $productCategory['image'] = $api['data']['image'];
            $productCategory['slug'] = $api['data']['slug'];

            $this->assertDatabaseHas(
                'product_categories',
                $productCategory
            );
        }

        $api = $this->json('GET', 'api/v1/product-category/read/root');

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );
    }

    public function test_product_category_api_call_read_leaf_categories_expect_collection()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $categories = ProductCategory::factory()->getProductCategoryExample();

        // Create a parent category

        $productCategory = ProductCategory::factory()->setName($categories[0])->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['image'] = $api['data']['image'];
        $productCategory['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );

        $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

        // Create a child category

        $productCategory = ProductCategory::factory()
            ->for($createdProductCategory, 'parent')
            ->setName($categories[1])
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['image'] = $api['data']['image'];
        $productCategory['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );

        $createdProductCategory = ProductCategory::find($api->json()['data']['id']);

        // Create a grandchild category

        $productCategory = ProductCategory::factory()
            ->for($createdProductCategory, 'parent')
            ->setName($categories[2])
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['image'] = $api['data']['image'];
        $productCategory['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );

        $api = $this->json('GET', 'api/v1/product-category/read/leaf');

        $api->assertSuccessful();

        $this->assertDatabaseHas(
            'product_categories',
            $productCategory
        );
    }

    public function test_product_category_api_call_read_empty_categories_expect_collection()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        ProductCategory::factory()
            ->has(Product::factory()->for(ProductBrand::factory()->create(), 'brand'))
            ->count(5)->create();

        ProductCategory::factory()->count(5)->create();

        $api = $this->json('GET', 'api/v1/product-category/read/no-product');

        $api->assertSuccessful();

        foreach ($api->json()['data'] as $category) {
            $productCategory = ProductCategory::find($category['id']);

            $this->assertFalse($productCategory->products()->exists());
        }
    }

    public function test_product_category_api_call_update_with_auto_code_and_empty_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productCategory = ProductCategory::factory()->make([
            'code' => 'AUTO',
            'slug' => '',
        ])->toArray();

        $api = $this->json('POST', 'api/v1/product-category', $productCategory);

        $api->assertSuccessful();

        $productCategory['id'] = $api['data']['id'];

        $updatedProductCategory = ProductCategory::factory()->make(['code' => 'AUTO'])->toArray();

        $api = $this->json('POST', 'api/v1/product-category/'.$productCategory['id'], $updatedProductCategory);

        $api->assertSuccessful();

        $updatedProductCategory['code'] = $api['data']['code'];
        $updatedProductCategory['image'] = $api['data']['image'];
        $updatedProductCategory['slug'] = $api['data']['slug'];

        $this->assertDatabaseHas(
            'product_categories',
            $updatedProductCategory
        );

        $this->assertTrue(Storage::disk('public')->exists($updatedProductCategory['image']));
    }

    public function test_product_category_api_call_update_with_random_code_and_slug_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productCategory = ProductCategory::factory()->create();

        $updatedProductCategory = ProductCategory::factory()->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category/'.$productCategory->id, $updatedProductCategory);

        $api->assertSuccessful();

        $updatedProductCategory['image'] = $api['data']['image'];

        $this->assertDatabaseHas(
            'product_categories',
            $updatedProductCategory
        );
    }

    public function test_product_category_api_call_update_with_random_code_and_slug_and_parent_has_been_used_on_products_expect_fail()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $parentCategory = ProductCategory::factory()->create();

        $brand = ProductBrand::factory()->create();

        Product::factory()->for($parentCategory, 'category')->for($brand, 'brand')->create();

        $category = ProductCategory::factory()->create();

        $updatedProductCategory = ProductCategory::factory()
            ->for($parentCategory, 'parent')
            ->make()->toArray();

        $api = $this->json('POST', 'api/v1/product-category/'.$category->id, $updatedProductCategory);

        $api->assertStatus(422);
    }

    public function test_product_category_api_call_delete_expect_successful()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $productCategory = ProductCategory::factory()->create();

        $api = $this->json('DELETE', 'api/v1/product-category/'.$productCategory->id);

        $api->assertSuccessful();

        $this->assertSoftDeleted(
            'product_categories',
            $productCategory->toArray()
        );
    }
}
