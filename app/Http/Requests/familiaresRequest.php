<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class familiaresRequest extends FormRequest
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
            'fecha_nac' => ['bail', 'nullable', 'date', 'before:today'],
            'apellido_nombres' => ['required', 'max:150'],
            'nro_doc' => ['required', 'numeric', 'digits_between:6,12']
        ];
    }
}
