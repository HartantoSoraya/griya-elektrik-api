<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWebConfigurationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required', 'max:255', 'string',
            'description' => 'required', 'max:255', 'string',
            'email' => 'nullable', 'max:255', 'email',
            'phone' => 'nullable', 'min:0', 'string',
            'logo' => 'nullable',  'string',
            'map' => 'nullable', 'string',
            'address' => 'required', 'max:255', 'string',
            'facebook' => 'nullable', 'max:255', 'string',
            'instagram' => 'nullable', 'min:0', 'string',
            'youtube' => 'nullable', 'max:255', 'string',
        ];
    }
}
