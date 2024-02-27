<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWebConfigurationRequest;
use App\Http\Resources\WebConfigurationResource;
use App\Interfaces\WebConfigurationRepositoryInterface;

class WebConfigurationController extends Controller
{
    private WebConfigurationRepositoryInterface $webConfigurationRepository;

    public function __construct(WebConfigurationRepositoryInterface $webConfigurationRepository)
    {
        $this->webConfigurationRepository = $webConfigurationRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $webConfigurations = $this->webConfigurationRepository->getWebConfiguration();

            return ResponseHelper::jsonResponse(true, 'Web Configurations retrieved successfully', new WebConfigurationResource($webConfigurations), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWebConfigurationRequest $request)
    {
        $request = $request->validated();

        try {
            $webConfiguration = $this->webConfigurationRepository->updateWebConfiguration($request);

            return ResponseHelper::jsonResponse(true, 'Web Configurations updated successfully', new WebConfigurationResource($webConfiguration), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, $e->getMessage(), [], 500);
        }
    }
}
