<?php

namespace App\Http\Controllers\api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchResource;
use App\Interfaces\BranchRepositoryInterface;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    private BranchRepositoryInterface $branch;

    public function __construct(BranchRepositoryInterface $branch)
    {
        $this->branch = $branch;
    }

    public function index()
    {
        try {
            $branches = $this->branch->getAllBranch();

            return ResponseHelper::jsonResponse(true, 'Success', BranchResource::collection($branches), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function readAllActiveBranch()
    {
        try {
            $branches = $this->branch->getAllActiveBranch();

            return ResponseHelper::jsonResponse(true, 'Success', BranchResource::collection($branches), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function readBranchById(Request $request, string $id)
    {
        try {
            $branch = $this->branch->getBranchById($id);

            if ($branch) {
                return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
            } else {
                return ResponseHelper::jsonResponse(false, 'Branch not found', null, 404);
            }
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function store(StoreBranchRequest $request)
    {
        try {
            $branch = $this->branch->createBranch($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function update(UpdateBranchRequest $request, string $id)
    {
        try {
            $branch = $this->branch->updateBranch($id, $request->all());

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function delete(Request $request, string $id)
    {
        try {
            $this->branch->deleteBranch($id);

            return ResponseHelper::jsonResponse(true, 'Success', null, 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
