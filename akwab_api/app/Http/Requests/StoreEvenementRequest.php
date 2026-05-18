<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreEvenementRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom'                      => 'required|string|max:255',
            'lieu'                     => 'required|string|max:255',
            'date'                     => 'required|date',
            'description'              => 'required|string',
            'prix_ticket'              => 'required|numeric|min:0',
            'nombre_ticket_disponible' => 'required|integer|min:0',
            'image'                    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_categorie'             => 'required|exists:categories,id_categorie',
        ];
    }
        protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erreur de validation',
            'errors' => $validator->errors()
        ], 422));
    }
}
