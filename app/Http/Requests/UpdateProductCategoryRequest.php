<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:product_categories,code,'.$this->route('id'),
            'name' => 'required|string|max:255',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'slug' => '',
        ]);
    }
}
