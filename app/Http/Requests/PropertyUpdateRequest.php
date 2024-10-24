<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:properties,slug'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
            'price' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'bedrooms' => ['required', 'integer'],
            'bathrooms' => ['required', 'integer'],
            'area' => ['required', 'numeric', 'between:-999999.99,999999.99'],
            'floor' => ['nullable', 'integer'],
            'furnished' => ['required'],
            'available' => ['required'],
            'type' => ['required', 'in:apartment,studio,duplex'],
            'status' => ['required', 'in:available,rented,maintenance'],
            'featured' => ['required'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
