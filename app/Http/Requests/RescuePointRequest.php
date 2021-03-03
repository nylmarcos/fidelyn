<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RescuePointRequest extends FormRequest
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
            'points' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'Telefone é obrigatório',
            'points.required'  => 'Quantidade de pontos é obrigatório',
        ];
    }
}
