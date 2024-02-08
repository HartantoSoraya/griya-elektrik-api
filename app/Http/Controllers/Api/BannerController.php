<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Http\Resources\BannerResource;
use App\Interfaces\BannerRepositoryInterface;

class BannerController extends Controller
{
    private BannerRepositoryInterface $bannerRepository;

    public function __construct(BannerRepositoryInterface $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $banners = $this->bannerRepository->getAllBanners();

            return ResponseHelper::jsonResponse(true, 'Banners retrieved successfully', BannerResource::collection($banners), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBannerRequest $request)
    {
        try {
            $banners = $this->bannerRepository->createBanner($request->all());

            return ResponseHelper::jsonResponse(true, 'Banners created successfully', new BannerResource($banners), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $banner = $this->bannerRepository->getBannerById($id);

            if (! $banner) {
                return ResponseHelper::jsonResponse(false, 'Banner not found', [], 404);
            }

            return ResponseHelper::jsonResponse(true, 'Banner retrieved successfully', new BannerResource($banner), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBannerRequest $request, string $id)
    {
        try {
            $this->bannerRepository->updateBanner($request->all(), $id);

            return ResponseHelper::jsonResponse(true, 'Banners updated successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->bannerRepository->deleteBanner($id);

            return ResponseHelper::jsonResponse(true, 'Banners deleted successfully', [], 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
