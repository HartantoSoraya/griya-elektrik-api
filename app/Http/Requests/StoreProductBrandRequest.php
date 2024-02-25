<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductBrandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:product_brands,code',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:product_brands,slug',
        ];
    }

    public function prepareForValidation()
    {
        if (! $this->has('slug')) {
            $this->merge(['slug' => null]);
        }
    }
}
