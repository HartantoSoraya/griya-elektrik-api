<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => 'required|string|max:255|unique:branches,code',
            'name' => 'required|string|max:255',
            'map' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'sort' => 'required|integer',
            'is_main' => 'required|boolean',
            'status' => 'required|boolean',
        ];
    }
}
