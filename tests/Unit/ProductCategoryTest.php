<?php

use App\Models\ProductCategory;

uses(Tests\TestCase::class);

test('product category can be listed', function () {
    $response = $this->getJson('/api/v1/product-categories');

    $response->assertStatus(200);
});

test('product category can be created', function () {
    $productCategory = ProductCategory::factory()->make()->toArray();

    $response = $this->postJson('/api/v1/product-categories', $productCategory);

    $response->assertStatus(200);

    $this->assertDatabaseHas('product_categories', $productCategory);
});

test('product category can be updated', function () {
    $productCategory = ProductCategory::factory()->create();

    $updatedProductCategory = ProductCategory::factory()->make()->toArray();

    $response = $this->postJson('/api/v1/product-categories/'.$productCategory->id, $updatedProductCategory);

    $this->assertDatabaseHas('product_categories', $updatedProductCategory);
});

test('product category can be deleted', function () {
    $productCategory = ProductCategory::factory()->create();

    $response = $this->deleteJson('/api/v1/product-categories/'.$productCategory->id);

    $response->assertStatus(200);
});
