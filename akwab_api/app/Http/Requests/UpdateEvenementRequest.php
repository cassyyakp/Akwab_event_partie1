<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEvenementRequest extends FormRequest
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
            'nom'                      => 'sometimes|string|max:255',
            'lieu'                     => 'sometimes|string|max:255',
            'date'                     => 'sometimes|date',
            'description'              => 'sometimes|string',
            'prix_ticket'              => 'sometimes|numeric|min:0',
            'nombre_ticket_disponible' => 'sometimes|integer|min:0',
            'image'                    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'id_categorie'             => 'sometimes|exists:categories,id_categorie',
        ];
    }
}
