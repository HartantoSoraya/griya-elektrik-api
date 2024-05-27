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
                'sort_order' => 1,
                'children' => [
                    ['name' => 'Bohlam', 'sort_order' => 1],
                    ['name' => 'Bohlam Hias', 'sort_order' => 2],
                    ['name' => 'Panel', 'sort_order' => 3],
                    ['name' => 'Tube Light', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Lampu Hias',
                'sort_order' => 2,
                'children' => [
                    ['name' => 'Lampu Gantung', 'sort_order' => 1],
                    ['name' => 'Lampu Plafon', 'sort_order' => 2],
                    ['name' => 'Lampu Dinding', 'sort_order' => 3],
                    ['name' => 'Lampu Outdoor', 'sort_order' => 4],
                    ['name' => 'Lampu Spot (Spotlight)', 'sort_order' => 5],
                    ['name' => 'LED Strip', 'sort_order' => 6],
                ],
            ],
            [
                'name' => 'Alat Listrik',
                'sort_order' => 3,
                'children' => [
                    ['name' => 'Kabel', 'sort_order' => 1],
                    ['name' => 'Peralatan Listrik', 'sort_order' => 2],
                    ['name' => 'Aksesoris Listrik', 'sort_order' => 3],
                    ['name' => 'Travo', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Aksesoris Rumah',
                'sort_order' => 4,
                'children' => [
                    ['name' => 'Pajangan', 'sort_order' => 1],
                    ['name' => 'Lukisan', 'sort_order' => 2],
                    ['name' => 'Bunga', 'sort_order' => 3],
                    ['name' => 'Pohon', 'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Elektronik',
                'sort_order' => 5,
                'children' => [
                    ['name' => 'Kipas', 'sort_order' => 1],
                    ['name' => 'Exhaust', 'sort_order' => 2],
                    ['name' => 'Speaker', 'sort_order' => 3],
                    ['name' => 'Rumah Tangga', 'sort_order' => 4],
                    ['name' => 'Lain - lain', 'sort_order' => 5],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $parentCategory = ProductCategory::factory()->create([
                'name' => $category['name'],
                'image' => $imageHelper->createDummyImageWithTextSizeAndPosition(500, 500, 'center', 'center', 'random', 'large')->store('assets/product-categories', 'public'),
                'sort_order' => $category['sort_order'],
            ]);

            foreach ($category['children'] as $child) {
                ProductCategory::factory()->create([
                    'parent_id' => $parentCategory->id,
                    'name' => $child['name'],
                    'image' => $imageHelper->createDummyImageWithTextSizeAndPosition(500, 500, 'center', 'center', 'random', 'large')->store('assets/product-categories', 'public'),
                    'sort_order' => $child['sort_order'],
                ]);
            }
        }
    }
}
