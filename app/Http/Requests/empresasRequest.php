<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class empresasRequest extends FormRequest
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
        return [  //   'sexo' => ['required'],
            'empresa_estado_id' => ['required'],
            'razon_social' => ['bail', 'nullable', 'max:150'],
            'cod_empresa' => ['required', 'numeric', 'digits_between:3,12']
            // 'telefono' => ['nullable', 'regex:/^[0-9\s-]{6,18}$/'],
            // 'email' => ["nullable", 'email'],
            // 'fecegreso' => ['required_with:egreso'],

        ];
    }
}
