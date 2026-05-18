<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthenficationRequest extends FormRequest
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
            'nom'          => 'required|string|max:255',
            'prenoms'      => 'required|string|max:255',
            'email'        => 'required|email|unique:utilisateurs,email',
            'telephone'    => 'required|string|max:20',
            'mot_de_passe' => 'required|string|min:8|confirmed',
        ];
    }
}
