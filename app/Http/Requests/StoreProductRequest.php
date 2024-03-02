<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'required|string|max:255|unique:products,code',
            'product_category_id' => 'required',
            'product_brand_id' => 'required',
            'name' => 'required|string|max:255',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
            'is_featured' => 'required|boolean',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug',
            'product_images' => 'nullable|array',
            'product_images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_links' => 'nullable|array',
            'product_links.*.name' => 'required|string|max:255',
            'product_links.*.url' => 'required|url',
        ];
    }

    public function prepareForValidation()
    {
        if (!$this->has('parent_id')) {
            $this->merge(['parent_id' => null]);
        }

        if (!$this->has('slug')) {
            $this->merge(['slug' => null]);
        }
    }
}
