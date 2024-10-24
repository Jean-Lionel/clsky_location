<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageStoreRequest extends FormRequest
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
            'sender_id' => ['required', 'integer', 'exists:senders,id'],
            'receiver_id' => ['required', 'integer', 'exists:receivers,id'],
            'property_id' => ['nullable', 'integer', 'exists:properties,id'],
            'subject' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'read_at' => ['nullable'],
        ];
    }
}
