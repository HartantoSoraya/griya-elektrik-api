<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\DB;

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
        DB::beginTransaction();

        try {
            // $product = Product::create($data);

            $product = new Product();
            $product->code = $data['code'];
            $product->product_category_id = $data['product_category_id'];
            $product->product_brand_id = $data['product_brand_id'];
            $product->name = $data['name'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->is_active = $data['is_active'];
            $product->slug = $data['slug'];
            $product->thumbnail = $data['thumbnail']->store('assets/products', 'public');
            $product->save();

            if (isset($data['product_images'])) {
                foreach ($data['product_images'] as $image) {
                    $product->productImages()->create([
                        'image' => $image,
                    ]);
                }
            }

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function updateProduct(string $id, array $data)
    {
        // $product = Product::find($id);

        // $product->update($data);

        // return $product;

        DB::beginTransaction();

        try {
            $product = Product::find($id);
            $product->code = $data['code'];
            $product->product_category_id = $data['product_category_id'];
            $product->product_brand_id = $data['product_brand_id'];
            $product->name = $data['name'];
            $product->description = $data['description'];
            $product->price = $data['price'];
            $product->is_active = $data['is_active'];
            $product->slug = $data['slug'];

            if (isset($data['thumbnail'])) {
                $product->thumbnail = $data['thumbnail']->store('assets/products', 'public');
            }

            $product->save();

            if (isset($data['product_images'])) {
                foreach ($data['product_images'] as $image) {
                    $product->productImages()->create([
                        'image' => $image,
                    ]);
                }
            }

            DB::commit();

            return $product;
        } catch (\Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

    public function deleteProduct(string $id)
    {
        return Product::find($id)->delete();
    }

    public function deleteProductImage(string $id)
    {
        return ProductImage::find($id)->delete();
    }

    public function generateCode(int $tryCount): string
    {
        $count = Product::count() + $tryCount;
        $code = str_pad($count, 2, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, ?string $expectId = null): bool
    {
        if (Product::count() == 0) {
            return true;
        }

        $result = Product::where('code', $code);

        if ($expectId) {
            $result = $result->where('id', '!=', $expectId);
        }

        return $result->count() == 0 ? true : false;
    }
}
