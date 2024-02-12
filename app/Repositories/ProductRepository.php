<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductImage;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts()
    {
        return Product::with('category', 'brand')->get();
    }

    public function getProductById(string $id)
    {
        return Product::with('category', 'brand')->find($id);
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(string $id, array $data)
    {
        $product = Product::find($id);

        $product->update($data);

        return $product;
    }

    public function deleteProduct(string $id)
    {
        return Product::find($id)->delete();
    }

    public function deleteProductImage(string $id)
    {
        return ProductImage::find($id)->delete();
    }
}
