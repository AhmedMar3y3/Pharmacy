<?php

namespace App\Http\Requests\medication;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicationRequest extends FormRequest
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
            'name'            => 'nullable|string',
            'price'           => 'nullable|numeric',
            'supported_price' => 'nullable|numeric',
            'quantity'        => 'nullable|numeric',
        ];
    }
}
