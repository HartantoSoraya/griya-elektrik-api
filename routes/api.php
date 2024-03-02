<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('web-configuration', [App\Http\Controllers\Api\WebConfigurationController::class, 'index']);

Route::get('banners', [App\Http\Controllers\Api\BannerController::class, 'index']);

Route::get('branches', [App\Http\Controllers\Api\BranchController::class, 'index']);
Route::get('branches/main', [App\Http\Controllers\Api\BranchController::class, 'readMainBranch']);
Route::get('branches/active', [App\Http\Controllers\Api\BranchController::class, 'getAllActiveBranch']);

Route::get('product-categories', [App\Http\Controllers\Api\ProductCategoryController::class, 'index']);
Route::get('product-categories/root', [App\Http\Controllers\Api\ProductCategoryController::class, 'readRootCategories']);
Route::get('product-categories/leaf', [App\Http\Controllers\Api\ProductCategoryController::class, 'readLeafCategories']);
Route::get('product-categories/empty', [App\Http\Controllers\Api\ProductCategoryController::class, 'readEmptyCategories']);
Route::get('product-categories/{id}', [App\Http\Controllers\Api\ProductCategoryController::class, 'show']);

Route::get('product-brands', [App\Http\Controllers\Api\ProductBrandController::class, 'index']);
Route::get('product-brands/{id}', [App\Http\Controllers\Api\ProductBrandController::class, 'show']);

Route::get('products', [App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('products/active', [App\Http\Controllers\Api\ProductController::class, 'readAllActiveProducts']);
Route::get('products/active-featured', [App\Http\Controllers\Api\ProductController::class, 'readAllActiveAndFeaturedProducts']);
Route::get('products/{id}', [App\Http\Controllers\Api\ProductController::class, 'show']);
Route::get('products/{slug}', [App\Http\Controllers\Api\ProductController::class, 'readProductBySlug']);

Route::post('login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('web-configuration', [App\Http\Controllers\Api\WebConfigurationController::class, 'update']);

    Route::post('branches', [App\Http\Controllers\Api\BranchController::class, 'store']);
    Route::post('branches/{id}', [App\Http\Controllers\Api\BranchController::class, 'update']);
    Route::post('branches/{id}/main', [App\Http\Controllers\Api\BranchController::class, 'updateMainBranch']);
    Route::post('branches/{id}/active', [App\Http\Controllers\Api\BranchController::class, 'updateActiveBranch']);
    Route::delete('branches/{id}', [App\Http\Controllers\Api\BranchController::class, 'destroy']);

    Route::delete('branch-images/{id}', [App\Http\Controllers\Api\BranchImageController::class, 'destroy']);

    route::post('banners', [App\Http\Controllers\Api\BannerController::class, 'store']);
    route::post('banners/{id}', [App\Http\Controllers\Api\BannerController::class, 'update']);
    route::delete('banners/{id}', [App\Http\Controllers\Api\BannerController::class, 'destroy']);

    Route::post('product-categories', [App\Http\Controllers\Api\ProductCategoryController::class, 'store']);
    Route::post('product-categories/{id}', [App\Http\Controllers\Api\ProductCategoryController::class, 'update']);
    Route::delete('product-categories/{id}', [App\Http\Controllers\Api\ProductCategoryController::class, 'destroy']);

    Route::post('product-brands', [App\Http\Controllers\Api\ProductBrandController::class, 'store']);
    Route::post('product-brands/{id}', [App\Http\Controllers\Api\ProductBrandController::class, 'update']);
    Route::delete('product-brands/{id}', [App\Http\Controllers\Api\ProductBrandController::class, 'destroy']);

    Route::post('products', [App\Http\Controllers\Api\ProductController::class, 'store']);
    Route::post('products/{id}', [App\Http\Controllers\Api\ProductController::class, 'update']);
    Route::post('products/{id}/active', [App\Http\Controllers\Api\ProductController::class, 'updateActiveProduct']);
    Route::post('products/{id}/featured', [App\Http\Controllers\Api\ProductController::class, 'updateFeaturedProduct']);
    Route::delete('products/{id}', [App\Http\Controllers\Api\ProductController::class, 'destroy']);
    route::delete('products/{id}/image', [App\Http\Controllers\Api\ProductController::class, 'deleteImage']);

    Route::get('me', [App\Http\Controllers\Api\AuthController::class, 'me']);
});
