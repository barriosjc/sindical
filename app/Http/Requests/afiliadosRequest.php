<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class afiliadosRequest extends FormRequest
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
            'afil_estado_ficha_id' => ['required'],
            'nro_afil_sindical' => ['required'],
            'fecnac' => ['bail', 'nullable', 'date', 'before:today'],
            'apellido_nombres' => ['required', 'max:150'],
            'nro_doc' => ['required', 'numeric', 'digits_between:6,12']
            // 'telefono' => ['nullable', 'regex:/^[0-9\s-]{6,18}$/'],
            // 'email' => ["nullable", 'email'],
            // 'fecegreso' => ['required_with:egreso'],

        ];
    }
}
