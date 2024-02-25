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
        $productBrand = ProductBrand::find($id);

        $productBrand->update($data);

        return $productBrand;
    }

    public function deleteBrand(string $id)
    {
        return ProductBrand::find($id)->delete();
    }

    public function generateCode(int $tryCount): string
    {
        $count = ProductBrand::count() + $tryCount;
        $code = str_pad($count, 2, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, ?string $expectId = null): bool
    {
        if (ProductBrand::count() == 0) {
            return true;
        }

        $result = ProductBrand::where('code', $code);

        if ($expectId) {
            $result->where('id', '!=', $expectId);
        }

        return $result->count() == 0;
    }

    public function isUniqueSlug(string $slug, ?string $expectId = null): bool
    {
        if (ProductBrand::count() == 0) {
            return true;
        }

        $result = ProductBrand::where('slug', $slug);

        if ($expectId) {
            $result->where('id', '!=', $expectId);
        }

        return $result->count() == 0;
    }
}
