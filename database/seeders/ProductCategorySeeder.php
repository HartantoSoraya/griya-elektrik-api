<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageHelper = new ImageHelper();

        $categories = [
            [
                'name' => 'Lampu',
                'children' => [
                    ['name' => 'Lampu Meja'],
                    ['name' => 'Lampu Dinding'],
                    ['name' => 'Lampu Taman'],
                    ['name' => 'Lampu Jalan'],
                ],
            ],
            [
                'name' => 'Bohlam',
                'children' => [
                    ['name' => 'Bohlam LED'],
                    ['name' => 'Bohlam Hemat Energi'],
                    ['name' => 'Bohlam Neon'],
                ],
            ],
            [
                'name' => 'Senter',
                'children' => [
                    ['name' => 'Senter Mini'],
                    ['name' => 'Senter Besar'],
                    ['name' => 'Senter Kepala'],
                ],
            ],
            [
                'name' => 'Lampu Emergency',
                'children' => [
                    ['name' => 'Lampu Emergency LED'],
                    ['name' => 'Lampu Emergency Hemat Energi'],
                    ['name' => 'Lampu Emergency Neon'],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $parentCategory = ProductCategory::factory()->create([
                'name' => $category['name'],
                'image' => $imageHelper->createDummyImageWithTextSizeAndPosition(500, 500, 'center', 'center', 'random', 'large')->store('assets/product-categories', 'public'),
            ]);

            foreach ($category['children'] as $child) {
                ProductCategory::factory()->create([
                    'parent_id' => $parentCategory->id,
                    'name' => $child['name'],
                    'image' => $imageHelper->createDummyImageWithTextSizeAndPosition(500, 500, 'center', 'center', 'random', 'large')->store('assets/product-categories', 'public'),
                ]);
            }
        }
    }
}
