<?php

namespace App\Interfaces;

interface ProductBrandRepositoryInterface
{
    public function getAllBrand();

    public function getBrandById(string $id);

    public function createBrand(array $data);

    public function updateBrand(string $id, array $data);

    public function deleteBrand(string $id);

    public function generateCode(int $tryCount);

    public function isUniqueCode(string $code, ?string $expectId = null);
}
