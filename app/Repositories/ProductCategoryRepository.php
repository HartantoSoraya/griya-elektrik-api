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

    public function getCategoryById(string $id)
    {
        return ProductCategory::find($id);
    }

    public function createCategory(array $data)
    {
        return ProductCategory::create($data);
    }

    public function updateCategory(string $id, array $data)
    {
        $productCategory = ProductCategory::find($id);

        $productCategory->update($data);

        return $productCategory;
    }

    public function deleteCategory(string $id)
    {
        return ProductCategory::find($id)->delete();
    }
}
