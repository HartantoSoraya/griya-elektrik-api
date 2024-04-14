<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductLink;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageHelper = new ImageHelper();

        $productCategory = ProductCategory::getLeafCategories();

        for ($i = 0; $i < 100; $i++) {
            $product = Product::factory()->create([
                'product_category_id' => $productCategory->random()->id,
                'product_brand_id' => ProductBrand::inRandomOrder()->first()->id,
                'thumbnail' => $imageHelper->createDummyImageWithTextSizeAndPosition(500, 500, 'center', 'center', 'random', 'large')->store('ssets/products/thumbnails', 'public'),
                'is_active' => true,
            ]);

            for ($j = 0; $j < mt_rand(0, 5); $j++) {
                ProductImage::factory()->create([
                    'product_id' => $product->id,
                    'image' => $imageHelper->createDummyImageWithTextSizeAndPosition(500, 500, 'center', 'center', 'random', 'large')->store('assets/products/images', 'public'),
                ]);
            }

            for ($j = 0; $j < mt_rand(0, 5); $j++) {
                ProductLink::factory()->create([
                    'product_id' => $product->id,
                ]);
            }
        }
    }
}
