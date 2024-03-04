<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'desktop_image' => $this->desktop_image,
            'desktop_image_url' => $this->desktop_image ? asset('storage/'.$this->desktop_image) : '',
            'mobile_image' => $this->mobile_image,
            'mobile_image_url' => $this->mobile_image ? asset('storage/'.$this->mobile_image) : '',
        ];
    }
}
