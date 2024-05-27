<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|exists:product_categories,id',
            'code' => 'required|string|max:255|unique:product_categories,code',
            'name' => 'required|max:255|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'nullable|integer',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug',
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->has('parent_id')) {
            $this->merge(['parent_id' => null]);
        }

        if (! $this->has('slug')) {
            $this->merge(['slug' => null]);
        }
    }
}
