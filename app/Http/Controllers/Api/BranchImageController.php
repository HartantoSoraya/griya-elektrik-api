<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchImageResource;
use App\Interfaces\BranchImageRepositoryInterface;
use Illuminate\Http\JsonResponse;

class BranchImageController extends Controller
{
    private BranchImageRepositoryInterface $branchImageRepository;

    public function __construct(BranchImageRepositoryInterface $branchImageRepository)
    {
        $this->branchImageRepository = $branchImageRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $branchImages = $this->branchImageRepository->getAllBranchImages();

            return ResponseHelper::jsonResponse(true, 'Branch images retrieved successfully', BranchImageResource::collection($branchImages), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request): JsonResponse
    {
        $request = $request->validated();

        try {
            $branchImage = $this->branchImageRepository->createBranchImage($request);

            return ResponseHelper::jsonResponse(true, 'Branch image created successfully', new BranchImageResource($branchImage), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $branchImage = $this->branchImageRepository->getBranchImageById($id);

            if (! $branchImage) {
                return ResponseHelper::jsonResponse(false, 'Branch image not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'Branch image retrieved successfully', new BranchImageResource($branchImage), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, string $id): JsonResponse
    {
        $request = $request->validated();

        try {
            $branchImage = $this->branchImageRepository->updateBranchImage($request, $id);

            return ResponseHelper::jsonResponse(true, 'Branch image updated successfully', new BranchImageResource($branchImage), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $this->branchImageRepository->deleteBranchImage($id);

            return ResponseHelper::jsonResponse(true, 'Branch image deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
