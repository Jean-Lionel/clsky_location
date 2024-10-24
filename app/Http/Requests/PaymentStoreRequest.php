<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
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
            'reservation_id' => ['required', 'integer', 'exists:reservations,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'payment_method' => ['required', 'in:card,bank_transfer,cash'],
            'transaction_id' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,completed,failed,refunded'],
        ];
    }
}
