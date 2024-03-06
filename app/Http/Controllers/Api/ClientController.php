<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Interfaces\ClientRepositoryInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $ClientRepository;

    public function __construct(ClientRepositoryInterface $ClientRepository)
    {
        $this->ClientRepository = $ClientRepository;
    }

    public function index(Request $request)
    {
        try {
            $clients = $this->ClientRepository->getAllClients();

            return ResponseHelper::jsonResponse(true, 'Success', ClientResource::collection($clients), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function store(StoreClientRequest $request)
    {
        $request = $request->validated();
        try {
            $client = $this->ClientRepository->create($request);

            return ResponseHelper::jsonResponse(true, 'Client created', new ClientResource($client), 201);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function show($id)
    {
        try {
            $client = $this->ClientRepository->getClientById($id);

            return ResponseHelper::jsonResponse(true, 'Success', new ClientResource($client), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $request = $request->validated();
        try {
            $client = $this->ClientRepository->update($id, $request);

            return ResponseHelper::jsonResponse(true, 'Client updated', new ClientResource($client), 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->ClientRepository->delete($id);

            return ResponseHelper::jsonResponse(true, 'Client deleted', null, 200);
        } catch (\Exception $exception) {
            return ResponseHelper::jsonResponse(false, $exception->getMessage(), null, 500);
        }
    }
}
