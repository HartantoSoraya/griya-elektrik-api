<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreWebConfigurationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required', 'max:255', 'string',
            'description' => 'required', 'max:255', 'string',
            'email' => 'nullable', 'max:255', 'email',
            'phone' => 'nullable', 'min:0', 'string',
            'logo' => 'nullable',  'string',
            'map' => 'nullable', 'string',
            'address' => 'nullable', 'max:255', 'string',
            'theme_color' => 'nullable', 'max:255', 'string',
            'facebook' => 'nullable', 'max:255', 'string',
            'instagram' => 'nullable', 'min:0', 'string',
            'youtube' => 'nullable', 'max:255', 'string',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors(),
        ]));
    }
}
