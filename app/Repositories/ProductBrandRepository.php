<?php

namespace App\Repositories;

use App\Interfaces\ProductBrandRepositoryInterface;
use App\Models\ProductBrand;

class ProductBrandRepository implements ProductBrandRepositoryInterface
{
    public function getAllBrand()
    {
        return ProductBrand::all();
    }

    public function getBrandById(string $id)
    {
        return ProductBrand::find($id);
    }

    public function createBrand(array $data)
    {
        return ProductBrand::create($data);
    }

    public function updateBrand(string $id, array $data)
    {
        return ProductBrand::find($id)->update($data);
    }

    public function deleteBrand(string $id)
    {
        return ProductBrand::find($id)->delete();
    }
}
