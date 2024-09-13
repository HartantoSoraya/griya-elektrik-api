<?php

namespace App\Repositories;

use App\Helpers\ImageHelper\ImageHelper;
use App\Interfaces\BannerRepositoryInterface;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerRepository implements BannerRepositoryInterface
{
    public function getAllBanners()
    {
        return Banner::all();
    }

    public function getBannerById($id)
    {
        return Banner::find($id);
    }

    public function createBanner($data)
    {
        $banner = new Banner();
        // $banner->desktop_image = $data['desktop_image']->store('assets/banners', 'public');
        // $banner->mobile_image = $data['mobile_image']->store('assets/banners', 'public');

        $banner->desktop_image = $this->saveImage($data['desktop_image']);
        $banner->mobile_image = $this->saveImage($data['mobile_image']);
        $banner->save();

        return $banner;
    }

    private function saveImage($image)
    {
        if ($image) {
            $path = $image->store('assets/banners', 'public');
            // $storagePath = storage_path('app/public/'.$path);

            $storagePath = Storage::disk('public')->path($path);
            $imageHelper = new ImageHelper();
            $imageHelper->resizeImage($storagePath, $storagePath, 1500, 1500);

            return $path;
        } else {
            return null;
        }
    }

    public function updateBanner($data, $id)
    {
        $banner = Banner::find($id);

        if ($data['desktop_image']) {
            // $banner->desktop_image = $this->updateImage($banner->desktop_image, $data['desktop_image']);
            $banner->desktop_image = $this->updateImage($data['desktop_image'], $banner->desktop_image);
        }
        if ($data['mobile_image']) {
            // $banner->mobile_image = $this->updateImage($banner->mobile_image, $data['mobile_image']);
            $banner->mobile_image = $this->updateImage($data['mobile_image'], $banner->mobile_image);
        }

        $banner->save();

        return $banner;
    }

    public function updateImage($image, $oldImagePath)
    {
        if ($image) {
            if ($oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }

            $path = $image->store('assets/banners', 'public');

            // $storagePath = storage_path('app/public/'.$path);
            $storagePath = Storage::disk('public')->path($path);
            $imageHelper = new ImageHelper();
            $imageHelper->resizeImage($storagePath, $storagePath, 1500, 1500);

            return $path;
        } else {
            return $oldImagePath;
        }
    }

    public function deleteBanner($id)
    {
        return Banner::destroy($id);
    }

    // private function updateImage($oldImage, $newImage): string
    // {
    //     if ($oldImage !== $newImage) {
    //         Storage::disk('public')->delete($oldImage);
    //     }

    //     return $newImage->store('assets/banners', 'public');
    // }
}
