<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePointRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'required',
            'price' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Telefone é obrigatório',
            'price.required'  => 'Valor da compra é obrigatório',
        ];
    }
}
