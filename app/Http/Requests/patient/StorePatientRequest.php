<?php

namespace App\Http\Requests\patient;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePatientRequest extends FormRequest
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
            "name"      => "required|string",
            "phone"     => "required|string",
            "address"   => "nullable|string",
            "ID_number"=> [
                "required",
                "string",
                Rule::unique("patients","ID_number")->whereNull("deleted_at"),
            ],
        ];
    }
}
