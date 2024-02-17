<?php

namespace App\Repositories;

use App\Interfaces\BranchRepositoryInterface;
use App\Models\Branch;

class BranchRepository implements BranchRepositoryInterface
{
    public function getAllBranch()
    {
        return Branch::orderBy('sort', 'asc')->get();
    }

    public function getAllActiveBranch()
    {
        return Branch::where('status', 1)->orderBy('sort', 'asc')->get();
    }

    public function getBranchById(string $id)
    {
        return Branch::find($id);
    }

    public function createBranch(array $data)
    {
        return Branch::create($data);
    }

    public function updateBranch(string $id, array $data)
    {
        $branch = Branch::find($id);

        $branch->update($data);

        return $branch;
    }

    public function updateMainBranch(string $id, bool $isMain)
    {
        Branch::where([
            ['id', '!=', $id],
            ['is_main', true],
        ])->update(['is_main' => false]);

        $branch = Branch::find($id);
        $branch->is_main = $isMain;
        $branch->save();

        return $branch;
    }

    public function updateActiveBranch(string $id, bool $isActive)
    {
        $branch = Branch::find($id);
        $branch->is_active = $isActive;
        $branch->save();

        return $branch;
    }

    public function deleteBranch(string $id)
    {
        return Branch::find($id)->delete();
    }

    public function generateCode(int $tryCount): string
    {
        $count = Branch::count() + $tryCount;
        $code = str_pad($count, 2, '0', STR_PAD_LEFT);

        return $code;
    }

    public function isUniqueCode(string $code, ?string $expectId = null): bool
    {
        if (Branch::count() == 0) {
            return true;
        }

        $result = Branch::where('code', $code);

        if ($expectId) {
            $result->where('id', '!=', $expectId);
        }

        return $result->count() == 0;
    }
}
