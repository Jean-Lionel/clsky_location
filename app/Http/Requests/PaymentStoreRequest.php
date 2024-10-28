<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reservation_id' => 'required|exists:reservations,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:card,bank_transfer,cash',
            'transaction_id' => 'nullable|string|max:255',
            'status' => 'required|in:pending,completed,failed',
        ];
    }

    public function messages(): array
    {
        return [
            'reservation_id.required' => 'La réservation est requise',
            'reservation_id.exists' => 'La réservation sélectionnée n\'existe pas',
            'amount.required' => 'Le montant est requis',
            'amount.numeric' => 'Le montant doit être un nombre',
            'amount.min' => 'Le montant doit être positif',
            'payment_method.required' => 'La méthode de paiement est requise',
            'payment_method.in' => 'La méthode de paiement sélectionnée n\'est pas valide',
            'status.required' => 'Le statut est requis',
            'status.in' => 'Le statut sélectionné n\'est pas valide',
        ];
    }
}