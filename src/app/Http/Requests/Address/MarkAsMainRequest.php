<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class MarkAsMainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'partner_id' => ['required', 'exists:partners,id'],
            'address_id' => ['required', 'exists:addresses,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'partner_id' => 'Informe o identificador do sócio',
            'address_id' => 'Informe o identificador do endereço',
        ];
    }
}
