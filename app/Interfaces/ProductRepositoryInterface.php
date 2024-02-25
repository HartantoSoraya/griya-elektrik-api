<?php

namespace App\Interfaces;

interface ProductRepositoryInterface
{
    public function getAllProducts();

    public function getProductById(string $id);

    public function createProduct(array $data);

    public function updateProduct(string $id, array $data);

    public function deleteProduct(string $id);

    public function deleteProductImage(string $id);

    public function generateCode(int $tryCount);

    public function isUniqueCode(string $code, ?string $expectId = null);

    public function isUniqueSlug(string $slug, ?string $expectId = null);
}
