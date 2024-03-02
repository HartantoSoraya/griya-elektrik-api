<?php

namespace App\Repositories;

use App\Interfaces\ProductCategoryRepositoryInterface;
use App\Models\ProductCategory;

class ProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    public function getAllCategory()
    {
        return ProductCategory::all();
    }

    public function getRootCategories()
    {
        $rootCategories = ProductCategory::getRootCategories();

        return $rootCategories;
    }

    public function getLeafCategories()
    {
        $leafCategories = ProductCategory::getLeafCategories();

        return $leafCategories;
    }

    public function getEmptyCategories()
    {
        $emptyCategories = ProductCategory::getEmptyCategories();

        return $emptyCategories;
    }

    public function getCategoryById(string $id)
    {
        return ProductCategory::find($id);
    }

    public function createCategory(array $data)
    {
        $productCategory = new ProductCategory();
        $productCategory->parent_id = $data['parent_id'];
        $productCategory->code = $data['code'];
        $productCategory->name = $data['name'];
        $productCategory->image = $data['image']->store('assets/product-categories', 'public');
        $productCategory->slug = $data['slug'];
        $productCategory->save();

        return $productCategory;
    }

    public function updateCategory(string $id, array $data)
    {
        $productCategory = ProductCategory::find($id);

        $productCategory->parent_id = $data['parent_id'];
        $productCategory->code = $data['code'];
        $productCategory->name = $data['name'];
        $productCategory->image = $data['image']->store('assets/product-categories', 'public') ?? $productCategory->image;
        $productCategory->slug = $data['slug'];
        $productCategory->save();

        return $productCategory;
    }

    public function deleteCategory(string $id)
    {
        return ProductCategory::find($id)->delete();
    }

    public function generateCode(int $tryCount): string
    {
        $count = ProductCategory::count() + $tryCount;
        $code = str_pad($count, 2, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, ?string $expectId = null): bool
    {
        if (ProductCategory::count() == 0) {
            return true;
        }

        $result = ProductCategory::where('code', $code);

        if ($expectId) {
            $result = $result->where('id', '!=', $expectId);
        }

        return $result->count() == 0 ? true : false;
    }

    public function isUniqueSlug(string $slug, ?string $expectId = null): bool
    {
        if (ProductCategory::count() == 0) {
            return true;
        }

        $result = ProductCategory::where('slug', $slug);

        if ($expectId) {
            $result = $result->where('id', '!=', $expectId);
        }

        return $result->count() == 0 ? true : false;
    }
}
