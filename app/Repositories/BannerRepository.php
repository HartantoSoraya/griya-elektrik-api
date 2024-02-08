<?php

namespace App\Repositories;

use App\Interfaces\BannerRepositoryInterface;
use App\Models\Banner;

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
        return Banner::create($data);
    }

    public function updateBanner($data, $id)
    {
        return Banner::find($id)->update($data);
    }

    public function deleteBanner($id)
    {
        return Banner::destroy($id);
    }
}
