<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'email_verified_at' => ['nullable'],
            'password' => ['required', 'password'],
            'phone' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'role' => ['required', 'in:admin,owner,tenant,agent'],
            'avatar' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'remember_token' => ['nullable', 'string'],
        ];
    }
}
