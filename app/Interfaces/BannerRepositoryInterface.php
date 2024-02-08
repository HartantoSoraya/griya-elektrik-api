<?php

namespace App\Interfaces;

interface BannerRepositoryInterface
{
    public function getAllBanners();

    public function getBannerById($id);

    public function createBanner($data);

    public function updateBanner($data, $id);

    public function deleteBanner($id);
}
