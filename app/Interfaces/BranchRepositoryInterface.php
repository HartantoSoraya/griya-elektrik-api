<?php

namespace App\Interfaces;

interface BranchRepositoryInterface
{
    public function getAllBranch();

    public function getAllActiveBranch();

    public function getBranchById(string $id);

    public function createBranch(array $data);

    public function updateBranch(string $id, array $data);

    public function deleteBranch(string $id);

    public function generateCode(int $tryCount);

    public function isUniqueCode(string $code, ?string $expectId = null);
}
