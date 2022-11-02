<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

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
    public function rules(Request $rq)
    {
        // dd($rq->fecha_ing_empr, $rq->fecha_egr_empr);
        return [
            'sexo' => ['required'],
            'afil_estado_ficha_id' => ['required'],
            'nro_afil_sindical' => ['required'],
            'fecha_nac' => ['required', 'nullable', 'date', 'before:today'],
            'sexo' => ['required'],
            'apellido_nombres' => ['required', 'max:150'],
            'tipo_documento_id' => ['required'],
            'nro_doc' => ['required', 'numeric', 'digits_between:6,12'],
            'fecha_egreso_os' => ['nullable','required_with:motivo_egreso_os_id', 'date', 'before_or_equal:today'],
            'motivo_egreso_os_id' => ['required_with:fecha_egreso_os'],
            'seccional_id' => ['required'],
            'empresa_id' => ['required'],
            'fecha_ingreso' => ['bail', 'required','required_with:fecha_egreso', 'date', 'before_or_equal:today'],
            'fecha_ing_empr' => ['bail', 'required','required_with:fecha_egr_empr', 'date', 'before_or_equal:today'],
            'delegado_desde' => ['bail', 'nullable','required_with:delegado_hasta', 'date', 'before_or_equal:today'],
            'motivo_egreso_id' => [function ($attribute, $value, $fail) use ($rq) {
                if (!($rq->input($attribute) == null)) {
                    if ($rq->input('fecha_egreso') == null) {
                        $fail('Si seleccionó Motivo de egreso es obligatorio el ingreso de Fecha de baja');
                    }
                }
            }
            ],

            'fecha_egreso' => ['bail', 
                function ($attribute, $value, $fail) use ($rq) {
                // dd($attribute, $rq->input('fecha_ing_empr'), $value, $value < $rq->input('fecha_ing_empr'));
                if (!($rq->input($attribute) == null)) {
                    if ($rq->input('motivo_egreso_id') == null) {
                        $fail('Si ingresa fecha de egreso es obligatorio seleccionar el Motivo de egreso');
                    }
                    if ($value < $rq->input('fecha_ingreso')) {
                        $fail('la Fecha de afiliación a la empresa debe ser menor a la Fecha de baja');
                    }
                }
            }
            ],

            'fecha_egr_empr' => [function ($attribute, $value, $fail) use ($rq) {
                // dd($attribute, $rq->input('fecha_ing_empr'), $value, $value < $rq->input('fecha_ing_empr'));
                if (!($rq->input($attribute) == null)) {
                    if ($rq->input('fecha_ing_empr') == null) {
                        $fail('Es obligatorio el ingreso de la fecha de ingreso');
                    }
                    if ($value < $rq->input('fecha_ing_empr')) {
                        $fail('la Fecha de ingreso a la empresa debe ser menor a la Fecha de egreso');
                    }
                }
            }
            ],

            'delegado_hasta' => [function ($attribute, $value, $fail) use ($rq) {
                // dd($attribute, $rq->input('fecha_ing_empr'), $value, $value < $rq->input('fecha_ing_empr'));
                if (!($rq->input($attribute) == null)) {
                    if ($rq->input('delegado_desde') == null) {
                        $fail('Es obligatorio el ingreso de la fecha de comienzo como delegado');
                    }
                    if ($value < $rq->input('delegado_desde')) {
                        $fail('la Fecha de comienzo como delegado en la empresa debe ser menor a la Fecha de finalización de delegado');
                    }
                }
            }
            ],
        ];
    }
}
