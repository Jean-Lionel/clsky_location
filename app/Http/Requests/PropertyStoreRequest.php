<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'postal_code' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'bathrooms' => ['required', 'integer', 'min:0'],
            'area' => ['required', 'numeric', 'min:0'],
            'floor' => ['nullable', 'integer', 'min:0'],
            'type' => ['required', 'string', 'in:apartment,studio,duplex'],
            'status' => ['required', 'string', 'in:available,rented,maintenance'],
            'furnished' => ['boolean'],
            'featured' => ['boolean'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est requis',
            'description.required' => 'La description est requise',
            'address.required' => 'L\'adresse est requise',
            'city.required' => 'La ville est requise',
            'country.required' => 'Le pays est requis',
            'postal_code.required' => 'Le code postal est requis',
            'price.required' => 'Le prix est requis',
            'price.numeric' => 'Le prix doit être un nombre',
            'price.min' => 'Le prix doit être positif',
            'bedrooms.required' => 'Le nombre de chambres est requis',
            'bathrooms.required' => 'Le nombre de salles de bain est requis',
            'area.required' => 'La surface est requise',
            'type.required' => 'Le type de bien est requis',
            'type.in' => 'Le type sélectionné n\'est pas valide',
            'status.required' => 'Le statut est requis',
            'status.in' => 'Le statut sélectionné n\'est pas valide',
            'images.*.image' => 'Le fichier doit être une image',
            'images.*.mimes' => 'L\'image doit être de type : jpeg, png, jpg',
            'images.*.max' => 'L\'image ne doit pas dépasser 2Mo',
            'images.max' => 'Vous ne pouvez pas uploader plus de 10 images.',
            'images.*.dimensions' => 'Les images doivent faire au minimum 400x300 pixels.',
        ];
    }
}