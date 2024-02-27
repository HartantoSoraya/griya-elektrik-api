<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductBrandRequest;
use App\Http\Requests\UpdateProductBrandRequest;
use App\Http\Resources\ProductBrandResource;
use App\Interfaces\ProductBrandRepositoryInterface;
use Illuminate\Support\Str;

class ProductBrandController extends Controller
{
    private ProductBrandRepositoryInterface $productBrand;

    public function __construct(ProductBrandRepositoryInterface $productBrand)
    {
        $this->productBrand = $productBrand;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $productBrands = $this->productBrand->getAllBrand();

            return ResponseHelper::jsonResponse(true, 'Success', ProductBrandResource::collection($productBrands), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * */
    public function store(StoreProductBrandRequest $request)
    {
        $request = $request->validated();

        try {
            $code = $request['code'];
            if ($code == 'AUTO') {
                $tryCount = 1;
                do {
                    $code = $this->productBrand->generateCode($tryCount);
                    $tryCount++;
                } while (! $this->productBrand->isUniqueCode($code));
                $request['code'] = $code;
            }

            if ($request['slug'] == '') {
                $slug = Str::slug($request['name'].$request['code']);
                $tryCount = 1;
                do {
                    $uniqueSlug = $slug.($tryCount > 1 ? '-'.$tryCount : '');
                    $tryCount++;
                } while (! $this->productBrand->isUniqueSlug($uniqueSlug));
                $request['slug'] = $uniqueSlug;
            }

            $productBrand = $this->productBrand->createBrand($request);

            return ResponseHelper::jsonResponse(true, 'Success', new ProductBrandResource($productBrand), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * */
    public function show($id)
    {
        try {
            $productBrand = $this->productBrand->getBrandById($id);

            if ($productBrand) {
                return ResponseHelper::jsonResponse(true, 'Success', new ProductBrandResource($productBrand), 200);
            }

            return ResponseHelper::jsonResponse(false, 'Data not found', null, 404);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * */
    public function update(UpdateProductBrandRequest $request, $id)
    {
        $request = $request->validated();

        try {
            $code = $request['code'];
            if ($code == 'AUTO') {
                $tryCount = 1;
                do {
                    $code = $this->productBrand->generateCode($tryCount);
                    $tryCount++;
                } while (! $this->productBrand->isUniqueCode($code, $id));
                $request['code'] = $code;
            }

            if ($request['slug'] == '') {
                $slug = Str::slug($request['name'].$request['code']);
                $tryCount = 1;
                do {
                    $uniqueSlug = $slug.($tryCount > 1 ? '-'.$tryCount : '');
                    $tryCount++;
                } while (! $this->productBrand->isUniqueSlug($uniqueSlug));
                $request['slug'] = $uniqueSlug;
            }

            $productBrand = $this->productBrand->updateBrand($id, $request);

            return ResponseHelper::jsonResponse(true, 'Success', new ProductBrandResource($productBrand), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * */
    public function destroy($id)
    {
        try {
            $this->productBrand->deleteBrand($id);

            return ResponseHelper::jsonResponse(true, 'Success', null, 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
