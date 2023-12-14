<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
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
            'name'     => ['required', 'string', 'min:3', 'max:191'],
            'email'    => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
            'password' => ['required', 'max:255', 'min:6', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name'               => 'Informe corretamente o nome',
            'email'              => 'Informe corretamente o e-mail',
            'email.unique'       => 'E-mail já cadastrado',
            'password'           => 'A senha deve ser informada',
            'password.confirmed' => 'As senhas informadas não coicidem',
            'password.min'       => 'Senha muito curta. Tente pelo menos 6 caracteres',
        ];
    }
}
