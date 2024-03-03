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
            'parent' => $this->parent_id ? new ProductCategoryResource($this->parent) : null,
            $this->mergeWhen($this->relationLoaded('children'), [
                'children' => ProductCategoryResource::collection($this->children),
            ]),
            $this->mergeWhen($this->relationLoaded('childrenRecursive'), [
                'children' => ProductCategoryResource::collection($this->childrenRecursive),
            ]),
            'code' => $this->code,
            'name' => $this->name,
            'image' => $this->image,
            'image_url' => $this->image ? asset('storage/'.$this->image) : '',
            'slug' => $this->slug,
        ];
    }
}
