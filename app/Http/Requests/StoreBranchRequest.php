<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:255|unique:branches,code',
            'name' => 'required|string|max:255',
            'map_url' => 'required|string|max:255',
            'iframe_map' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'sort' => 'required|integer',
            'is_main' => 'required|boolean',
            'is_active' => 'required|boolean',
            'branch_images' => 'nullable|array',
            'branch_images.*.id' => 'nullable|string',
            'branch_images.*.image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('branch_images')) {
            $branchImages = $this->branch_images;
            foreach ($branchImages as $index => $branchImage) {
                if (! isset($branchImage['id'])) {
                    $branchImages[$index]['id'] = null;
                }
            }
            $this->merge(['branch_images' => $branchImages]);
        } else {
            $this->merge(['branch_images' => []]);
        }
    }
}
