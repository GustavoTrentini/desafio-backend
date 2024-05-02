<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'phone' => 'size:11',
            'document' => 'required|min:11|max:14|unique:users,document',
            'type_user_id' => 'required|integer',
        ];
    }

    public function messages() : array
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'email.required' => 'O campo email é obrigatório',
            'email.email' => 'O campo email deve ser um email válido',
            'email.unique' => 'Esse email já está sendo utilizado',
            'password.required' => 'O campo senha é obrigatório',
            'password.min' => 'O campo senha deve ter no mínimo 6 caracteres',
            'password.confirmed' => 'O campo senha deve ser igual ao campo de confirmação',
            'document.required' => 'O campo documento é obrigatório',
            'document.min' => 'O campo documento deve ter no mínimo 11 caracteres',
            'document.max' => 'O campo documento deve ter no máximo 14 caracteres',
            'document.unique' => 'Esse documento já está sendo utilizado',
            'type_user_id.required' => 'O campo tipo de usuário é obrigatório',
            'type_user_id.integer' => 'O campo tipo de usuário deve ser um número inteiro',
            'phone.size' => 'O campo telefone deve ter 11 caracteres',
        ];
    }
}
