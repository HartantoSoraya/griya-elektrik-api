<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'slug' => $this->slug,
            'category' => $this->category,
            'brand' => $this->brand,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'thumbnail_url' => $this->thumbnail ? asset('storage/'.$this->thumbnail) : '',
            'description' => $this->description,
            'price' => $this->price,
            'is_featured' => $this->is_featured,
            'is_active' => $this->is_active,
            'product_images' => ProductImageResource::collection($this->productImages),
            'product_links' => ProductLinkResource::collection($this->productLinks),
        ];
    }
}
