<?php

namespace App\Repositories;

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
        $banner->image = $data['image']->store('assets/banners', 'public');
        $banner->save();

        return $banner;
    }

    public function updateBanner($data, $id)
    {
        $banner = Banner::find($id);
        $banner->image = $this->updateImage($banner->image, $data['image']);
        $banner->save();

        return $banner;
    }

    public function deleteBanner($id)
    {
        return Banner::destroy($id);
    }

    private function updateImage($oldImage, $newImage): string
    {
        if ($oldImage !== $newImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return $newImage->store('assets/banners', 'public');
    }
}
