<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'parent_id' => $this->parent_id ? new ProductCategoryResource($this->parent) : null,
            'children' => ProductCategoryResource::collection($this->children),
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }
}
