<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationStoreRequest extends FormRequest
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
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date'],
            'total_price' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'guests' => ['required', 'integer'],
            'status' => ['required', 'in:pending,confirmed,cancelled,completed'],
            'payment_status' => ['required', 'in:pending,paid,refunded'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
