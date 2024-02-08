<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'required',
            'slug' => 'required|unique:product_categories,slug',
            'product_category_id' => 'required',
            'product_brand_id' => 'required',
            'name' => 'required', 'max:255', 'string',
            'description' => 'required', 'max:255', 'string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ];
    }
}
