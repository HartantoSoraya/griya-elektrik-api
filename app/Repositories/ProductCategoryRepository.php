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
        return ProductCategory::find($id)->update($data);
    }

    public function deleteCategory(string $id)
    {
        return ProductCategory::find($id)->delete();
    }
}
