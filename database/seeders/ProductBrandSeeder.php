<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\ProductBrand;
use Illuminate\Database\Seeder;

class ProductBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageHelper = new ImageHelper();

        for ($i = 0; $i < mt_rand(5, 20); $i++) {
            $logo = $imageHelper->createDummyImageWithTextSizeAndPosition(200, 200, 'center', 'center', 'random', 'large');
            ProductBrand::factory()->create([
                'logo' => $logo->store('assets/product-brands', 'public'),
            ]);
        }
    }
}
