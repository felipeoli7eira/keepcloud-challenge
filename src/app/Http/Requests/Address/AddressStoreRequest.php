<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
            'cep' => ['required', 'string', 'min:8', 'max:8'],
            'numero' => ['required', 'string', 'max:15'],
            'logradouro' => ['required', 'string', 'max:191'],
            'bairro' => ['required', 'string', 'max:191', 'min:3'],
            'uf' => ['required', 'string', 'max:2', 'min:2'],
            'cidade' => ['required', 'string', 'max:191', 'min:3'],
            'complemento' => ['string', 'max:50', 'nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'cep' => 'Informe um CEP com no mínimo e no máximo 8 números',
            'numero'    => 'Informe o número da residência',
            'logradouro' => 'Informe o logradouro corretamente',
            'bairro' => 'Informe o bairro corretamente',
            'uf' => 'Informe a UF corretamente',
            'cidade' => 'Informe a cidade corretamente',
            'complemento' => 'O complemento deve ter no máximo 50 caracteres',
        ];
    }
}
