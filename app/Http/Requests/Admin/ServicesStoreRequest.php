<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServicesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'device_type_name' => 'required|string|min:3|max:255',
            'issue_category_name' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:10|max:1000',
            'base_price' => 'required|numeric|min:0',
            'slug' => 'nullable|string|max:255|regex:/^[a-z0-9\-]+$/|unique:services,slug',
        ];
    }

    public function messages()
    {
        return [
            'device_type_name.required' => 'Device type is required.',
            'device_type_name.string' => 'Device type must be a string.',
            'device_type_name.min' => 'Device type must be at least 3 characters.',
            'device_type_name.max' => 'Device type may not be greater than 255 characters.',

            'issue_category_name.required' => 'Issue category name is required.',
            'issue_category_name.string' => 'Issue category name must be a string.',
            'issue_category_name.min' => 'Issue category name must be at least 3 characters.',
            'issue_category_name.max' => 'Issue category name may not be greater than 255 characters.',

            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a string.',
            'description.min' => 'Description must be at least 10 characters.',
            'description.max' => 'Description may not be greater than 1000 characters.',

            'base_price.required' => 'Service price is required.',
            'base_price.numeric' => 'Service price must be a number.',
            'base_price.min' => 'Service price must be at least 0.',

            'slug.string' => 'Slug must be a string.',
            'slug.max' => 'Slug may not be greater than 255 characters.',
            'slug.regex' => 'Slug must contain only lowercase letters, numbers, and hyphens.',
            'slug.unique' => 'This slug is already taken. Please use a different one.',
        ];
    }
}
