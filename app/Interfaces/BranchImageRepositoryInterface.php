<?php

namespace App\Interfaces;

interface BranchImageRepositoryInterface
{
    public function getAllBranchImages();

    public function getBranchImageById($id);

    public function createBranchImage($data);

    public function updateBranchImage($data, $id);

    public function deleteBranchImage($id);
}
