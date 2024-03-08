<?php

namespace App\Http\Requests;

use App\Rules\DateRule;
use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
            'sender' => 'required',
            'receiver' => 'required',
            'date' => ['date', new DateRule()],
            'value' => 'required|decimal:2|min:0.01',
        ];
    }

    public function messages()
    {
        return [
            'sender.required' => 'ID do remetente é obrigatório.',
            'receiver.required' => 'ID do destinatário é obrigatório.',
            'date.required' => 'A data é obrigatório.',
            'date.date' => 'A data deve ser uma data válida.',
            'value.required' => 'Informe o valor a ser transferido.',
            'value.min' => 'Valor mínimo 0.01.',
            'value.decimal' => 'valor deve ter 2 casas decimais.',
        ];
    }
}
