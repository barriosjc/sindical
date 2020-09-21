<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class denunciasRequest extends FormRequest
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
            'numero' => ['required', 'numeric', 'digits_between:3,10'],
            'fecha_ingreso' => ['required','date',  'before_or_equal:today'],
            'tipo_denuncia_id' => ['required'],
            'nro_dni' => ['nullable', 'numeric', 'digits_between:6,12'],
            'nombre' => ['required',  'max:150'],
            'empresa' => ['required',  'max:250'],
            'descripcion' => ['required'],
            'tomo_denuncia' => ['required',  'max:150'],
            'tipo_movimiento_id' => ['required'],
            'afiliado_id' => ['required_with:nro_dni']
            ];
    }
    public function messages()
    {
        return [
            'afiliado_id.required_with' => 'Ingreso un Nro de DNI y haga click en el botón para controlar si esta empadronado el afiliado ingresado.'
    ] ;
    }    
}
