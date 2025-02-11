<?php

namespace App\Http\Requests\patient;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            "name"       => "nullable|string",
            "phone"      => "nullable|string",
            "worker_num" => "nullable|string",
            "contract_id"=> "nullable|exists:contracts,id",
            "ID_number"  => [
                "nullable",
                "string",
                Rule::unique('patients', 'ID_number')->ignore($this->route('patient')),
            ],
        ];
    }
}
