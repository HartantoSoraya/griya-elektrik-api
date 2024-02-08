<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Interfaces\ProductCategoryRepositoryInterface;

class ProductCategoryController extends Controller
{
    private ProductCategoryRepositoryInterface $productCategory;

    public function __construct(ProductCategoryRepositoryInterface $productCategory)
    {
        $this->productCategory = $productCategory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $productCategories = $this->productCategory->getAllCategory();

            return ResponseHelper::jsonResponse(true, 'Success', ProductCategoryResource::collection($productCategories), 200);
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
    public function store(StoreProductCategoryRequest $request)
    {
        try {
            $productCategory = $this->productCategory->createCategory($request->all());

            return ResponseHelper::jsonResponse(true, 'Success', new ProductCategoryResource($productCategory), 200);
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
            $productCategory = $this->productCategory->getCategoryById($id);

            if ($productCategory) {
                return ResponseHelper::jsonResponse(true, 'Success', new ProductCategoryResource($productCategory), 200);
            }

            return ResponseHelper::jsonResponse(false, 'Data not found', null, 404);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * */
    public function update(StoreProductCategoryRequest $request, $id)
    {
        try {
            $productCategory = $this->productCategory->updateCategory($id, $request->all());

            return ResponseHelper::jsonResponse(true, 'Success', new ProductCategoryResource($productCategory), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->productCategory->deleteCategory($id);

            return ResponseHelper::jsonResponse(true, 'Success', null, 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
