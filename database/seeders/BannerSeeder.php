<?php

namespace Database\Seeders;

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $imageHelper = new ImageHelper();

        for ($i = 0; $i < 3; $i++) {
            $desktopImage = $imageHelper->createDummyImageWithTextSizeAndPosition(1240, 350, 'center', 'center', 'random', 'small');
            $mobileImage = $imageHelper->createDummyImageWithTextSizeAndPosition(350, 150, 'center', 'center', 'random', 'small');

            Banner::factory()->create([
                'desktop_image' => $desktopImage->store('assets/banners', 'public'),
                'mobile_image' => $mobileImage->store('assets/banners', 'public'),
            ]);
        }
    }
}
