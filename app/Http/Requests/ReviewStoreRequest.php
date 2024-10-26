<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
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
            'property_id' => ['required', 'integer', 'exists:properties,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'reservation_id' => ['nullable', 'integer', 'exists:reservations,id'],
            'rating' => ['required', 'integer'],
            'comment' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ];
    }
}