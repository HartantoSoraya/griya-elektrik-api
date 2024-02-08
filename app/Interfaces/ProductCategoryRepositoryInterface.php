<?php

namespace App\Interfaces;

interface ProductCategoryRepositoryInterface
{
    public function getAllCategory();

    public function getCategoryById(string $id);

    public function createCategory(array $data);

    public function updateCategory(string $id, array $data);

    public function deleteCategory(string $id);
}
