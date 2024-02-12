<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductCategoryApiTest extends TestCase
{
    public function test_product_category_api_call_create_expect_successfull()
    {
        $password = '1234567890';
        $user = User::factory()->create(['password' => $password]);

        $this->actingAs($user);

        $api = $this->json('POST', 'api/v1/login', array_merge($user->toArray(), ['password' => $password]));

        $api->assertSuccessful();

        $productCategory = [
            'name' => 'Category 1',
            'slug' => 'category-1',
        ];

        $api = $this->json('POST', 'api/v1/product-categories', $productCategory);

        $api->assertSuccessful();
    }
}
