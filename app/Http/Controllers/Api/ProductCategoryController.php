<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Interfaces\ProductCategoryRepositoryInterface;
use Illuminate\Support\Str;

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

    public function readRootCategories()
    {
        try {
            $rootCategories = $this->productCategory->getRootCategories();

            return ResponseHelper::jsonResponse(true, 'Success', ProductCategoryResource::collection($rootCategories), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function readLeafCategories()
    {
        try {
            $leafCategories = $this->productCategory->getLeafCategories();

            return ResponseHelper::jsonResponse(true, 'Success', ProductCategoryResource::collection($leafCategories), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function readEmptyCategories()
    {
        try {
            $emptyCategories = $this->productCategory->getEmptyCategories();

            return ResponseHelper::jsonResponse(true, 'Success', ProductCategoryResource::collection($emptyCategories), 200);
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
        $request = $request->validated();

        try {
            if ($request['parent_id']) {
                $parentCategory = $this->productCategory->getCategoryById($request['parent_id']);

                if ($parentCategory->products()->exists()) {
                    return ResponseHelper::jsonResponse(false, 'Parent category is used in a product, cannot save.', null, 422);
                }
            }

            $code = $request['code'];
            if ($code == 'AUTO') {
                $tryCount = 1;
                do {
                    $code = $this->productCategory->generateCode($tryCount);
                    $tryCount++;
                } while (! $this->productCategory->isUniqueCode($code));
                $request['code'] = $code;
            }

            if ($request['slug'] == '') {
                $slug = Str::slug($request['name'].$request['code']);
                $tryCount = 1;
                do {
                    $uniqueSlug = $slug.($tryCount > 1 ? '-'.$tryCount : '');
                    $tryCount++;
                } while (! $this->productCategory->isUniqueSlug($uniqueSlug));
                $request['slug'] = $uniqueSlug;
            }

            $productCategory = $this->productCategory->createCategory($request);

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
    public function update(UpdateProductCategoryRequest $request, $id)
    {
        $request = $request->validated();

        try {
            if ($request['parent_id']) {
                $category = $this->productCategory->getCategoryById($id);
                $parentCategory = $this->productCategory->getCategoryById($request['parent_id']);

                if ($parentCategory->products()->exists()) {
                    return ResponseHelper::jsonResponse(false, 'Parent category is used in a product, cannot save.', null, 422);
                }

                if ($parentCategory->id == $id) {
                    return ResponseHelper::jsonResponse(false, 'Invalid category hierarchy: cannot be its own parent.', null, 422);
                }

                if ($this->productCategory->isAncestor($request['parent_id'], $id)) {
                    return ResponseHelper::jsonResponse(false, 'Invalid category hierarchy: cannot be a descendant of itself.', null, 422);
                }

                if ($category->children()->exists()) {
                    if ($category->parent_id != $request['parent_id']) {
                        return ResponseHelper::jsonResponse(false, 'Cannot change parent category because it has children.', null, 422);
                    }
                }
            }

            $code = $request['code'];
            if ($code == 'AUTO') {
                $tryCount = 1;
                do {
                    $code = $this->productCategory->generateCode($tryCount);
                    $tryCount++;
                } while (! $this->productCategory->isUniqueCode($code, $id));
                $request['code'] = $code;
            }

            if ($request['slug'] == '') {
                $slug = Str::slug($request['name'].$request['code']);
                $tryCount = 1;
                do {
                    $uniqueSlug = $slug.($tryCount > 1 ? '-'.$tryCount : '');
                    $tryCount++;
                } while (! $this->productCategory->isUniqueSlug($uniqueSlug));
                $request['slug'] = $uniqueSlug;
            }

            $productCategory = $this->productCategory->updateCategory($id, $request);

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
