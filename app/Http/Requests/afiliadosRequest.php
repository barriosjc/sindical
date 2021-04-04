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
            'fecha_nac' => ['bail', 'nullable', 'date', 'before:today'],
            'apellido_nombres' => ['required', 'max:150'],
            'nro_doc' => ['required', 'numeric', 'digits_between:6,12'],
            'fecha_egreso' => ['nullable','required_with:motivo_egreso_id', 'date', 'before_or_equal:today'],
            'motivo_egreso_id' => ['required_with:fecha_egreso'],
            'fecha_egreso_os' => ['nullable','required_with:motivo_egreso_os_id', 'date', 'before_or_equal:today'],
            'motivo_egreso_os_id' => ['required_with:fecha_egreso_os'],
            'delegado_desde' => ['bail', 'nullable','required_with:delegado_hasta', 'date', 'before_or_equal:delegado_hasta'],
            'delegado_hasta' => ['required_with:delegado_desde'],
        ];
    }
}
