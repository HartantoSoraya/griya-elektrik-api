<?php

namespace App\Http\Controllers\Api;

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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $branches = $this->branch->getAllBranch();

            return ResponseHelper::jsonResponse(true, 'Success', BranchResource::collection($branches), 200);
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
    public function store(StoreBranchRequest $request)
    {
        $request = $request->validated();

        try {
            $code = $request['code'];

            if ($code == 'AUTO') {
                $tryCount = 1;
                do {
                    $code = $this->branch->generateCode($tryCount);
                    $tryCount++;
                } while (! $this->branch->isUniqueCode($code));
                $request['code'] = $code;
            }

            $branch = $this->branch->createBranch($request);

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {

            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        try {
            $branch = $this->branch->getBranchById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * */
    public function update(UpdateBranchRequest $request, string $id)
    {
        $request = $request->validated();

        try {
            $code = $request['code'];
            if ($code == 'AUTO') {
                $tryCount = 1;
                do {
                    $code = $this->branch->generateCode($tryCount);
                    $tryCount++;
                } while (! $this->branch->isUniqueCode($code, $id));
                $request['code'] = $code;
            }

            $branch = $this->branch->updateBranch($id, $request);

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function updateMainBranch(Request $request, string $id)
    {
        try {
            $branch = $this->branch->updateMainBranch($id, $request->is_main);

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function updateActiveBranch(Request $request, string $id)
    {
        try {
            $branch = $this->branch->updateActiveBranch($id, $request->is_active);

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     * */
    public function destroy(string $id)
    {
        try {
            $this->branch->deleteBranch($id);

            return ResponseHelper::jsonResponse(true, 'Success', null, 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
