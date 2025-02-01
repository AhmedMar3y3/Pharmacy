<?php

namespace App\Http\Requests\patient;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"      => "nullable|string",
            "ID_number" => "nullable|string|unique:patients,ID_number",
            "phone"     => "nullable|string",
            "address"   => "nullable|string",
        ];
    }
}
