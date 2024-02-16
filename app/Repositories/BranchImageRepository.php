<?php

namespace App\Repositories;

use App\Interfaces\BranchImageRepositoryInterface;
use App\Models\BranchImage;

class BranchImageRepository implements BranchImageRepositoryInterface
{
    public function getAllBranchImages()
    {
        return BranchImage::all();
    }

    public function getBranchImageById($id)
    {
        return BranchImage::find($id);
    }

    public function createBranchImage($data)
    {
        return BranchImage::create($data);
    }

    public function updateBranchImage($data, $id)
    {
        return BranchImage::find($id)->update($data);
    }

    public function deleteBranchImage($id)
    {
        return BranchImage::destroy($id);
    }
}
