<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Http\Resources\BranchResource;
use App\Interfaces\BranchRepositoryInterface;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        try {
            DB::beginTransaction();

            $branch = new Branch();

            $code = $request->code;
            if ($code == 'AUTO') {
                $tryCount = 1;
                do {
                    $code = $this->branch->generateCode($tryCount);
                    $tryCount++;
                } while (! $this->branch->isUniqueCode($code));
                $branch->code = $code;
            }

            $branch->name = $request->name;
            $branch->map = $request->map;
            $branch->address = $request->address;
            $branch->city = $request->city;
            $branch->email = $request->email;
            $branch->phone = $request->phone;
            $branch->facebook = $request->facebook;
            $branch->instagram = $request->instagram;
            $branch->youtube = $request->youtube;
            $branch->sort = $request->sort;
            $branch->is_main = $request->is_main;
            $branch->is_active = $request->is_active;
            $branch->save();

            foreach ($request->branch_images as $image) {
                $branch->branchImages()->create(['image' => $image]);
            }

            DB::commit();

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {
            DB::rollBack();

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
        try {
            DB::beginTransaction();

            $branch = new Branch();

            $code = $request->code;
            if ($code == 'AUTO') {
                $tryCount = 1;
                do {
                    $code = $this->branch->generateCode($tryCount);
                    $tryCount++;
                } while (! $this->branch->isUniqueCode($code, $id));
                $code = $code;
            }

            $branch->name = $request->name;
            $branch->map = $request->map;
            $branch->address = $request->address;
            $branch->city = $request->city;
            $branch->email = $request->email;
            $branch->phone = $request->phone;
            $branch->facebook = $request->facebook;
            $branch->instagram = $request->instagram;
            $branch->youtube = $request->youtube;
            $branch->sort = $request->sort;
            $branch->is_main = $request->is_main;
            $branch->is_active = $request->is_active;
            $branch->save();

            DB::commit();

            return ResponseHelper::jsonResponse(true, 'Success', new BranchResource($branch), 200);
        } catch (\Exception $exception) {
            DB::rollBack();

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
