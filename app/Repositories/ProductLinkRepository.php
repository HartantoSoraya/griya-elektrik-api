<?php

namespace App\Repositories;

use App\Interfaces\ProductLinkRepositoryInterface;
use App\Models\ProductLink;
use Illuminate\Support\Facades\DB;

class ProductLinkRepository implements ProductLinkRepositoryInterface
{
    public function getAllProductLinks()
    {
        return ProductLink::with('product')->get();
    }

    public function getProductLinkById(string $id)
    {
        return ProductLink::with('product')->find($id);
    }

    public function createProductLink(array $data)
    {
        DB::beginTransaction();

        try {
            $productLink = new ProductLink();
            $productLink->product_id = $data['product_id'];
            $productLink->name = $data['name'];
            $productLink->url = $data['url'];
            $productLink->save();

            DB::commit();

            return $productLink;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateProductLink(string $id, array $data)
    {
        DB::beginTransaction();

        try {
            $productLink = ProductLink::find($id);
            $productLink->product_id = $data['product_id'];
            $productLink->name = $data['name'];
            $productLink->url = $data['url'];
            $productLink->save();

            DB::commit();

            return $productLink;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteProductLink(string $id)
    {
        DB::beginTransaction();

        try {
            $productLink = ProductLink::find($id);
            $productLink->delete();

            DB::commit();

            return $productLink;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
