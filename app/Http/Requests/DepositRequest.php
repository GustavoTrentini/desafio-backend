<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
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
            'value' => 'required|min:0.01|numeric',
        ];
    }

    public function messages() : array
    {
        return [
            'value.required' => 'O campo valor é obrigatório',
            'value.min' => 'O campo valor deve ser no mínimo 0.01',
            'value.numeric' => 'O campo valor deve ser um número',
        ];
    }
}
