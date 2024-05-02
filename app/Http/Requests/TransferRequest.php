<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest
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
            'payee' => "required|integer|exists:users,id|not_in:".auth()->id(),
            'value' => 'required|min:0.01|numeric',
            'description' => 'max:255',
        ];
    }

    public function messages() : array
    {
        return [
            'payer.required' => 'O campo pagador é obrigatório',
            'payer.integer' => 'O campo pagador deve ser um número inteiro',
            'payer.exists' => 'O pagador informado não existe',
            'payee.required' => 'O campo beneficiário é obrigatório',
            'payee.integer' => 'O campo beneficiário deve ser um número inteiro',
            'payee.exists' => 'O beneficiário informado não existe',
            'payee.not_in' => 'O pagador e o beneficiário não podem ser a mesma pessoa',
            'value.required' => 'O campo valor é obrigatório',
            'value.min' => 'O campo valor deve ser no mínimo 0.01',
            'value.numeric' => 'O campo valor deve ser um número',
            'description.max' => 'O campo descrição deve ter no máximo 255 caracteres',
        ];
    }
}
