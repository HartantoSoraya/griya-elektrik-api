<?php

use App\Helpers\ImageHelper\ImageHelper;
use App\Models\Banner;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $imageHelper = new ImageHelper();

        $banners = Banner::withoutTrashed()->get();
        foreach ($banners as $banner) {
            if ($banner->desktop_image) {
                $path = storage_path('app/public/'.$banner->desktop_image);
                $imageHelper->resizeImage($path, $path, 1500, 1500);

                echo $path."\n";
            }

            if ($banner->mobile_image) {
                $path = storage_path('app/public/'.$banner->mobile_image);
                $imageHelper->resizeImage($path, $path, 1500, 1500);

                echo $path."\n";
            }
        }

        $productCategory = ProductCategory::withoutTrashed()->get();
        foreach ($productCategory as $category) {
            if ($category->image) {
                $path = storage_path('app/public/'.$category->image);
                $imageHelper->resizeImage($path, $path, 500, 500);

                echo $path."\n";
            }
        }

        $thumbnails = Product::pluck('thumbnail')->toArray();
        foreach ($thumbnails as $thumbnail) {
            if ($thumbnail) {
                // $path =  $_SERVER['DOCUMENT_ROOT'] . '/storage/'. $thumbnail;
                $path = storage_path('app/public/'.$thumbnail);
                $imageHelper->resizeImage($path, $path, 500, 500);

                echo $path."\n";
            }
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
