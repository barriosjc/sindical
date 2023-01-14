<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\models\grupo_familiar;
use App\models\afiliado_empresa;

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
    public function rules(Request $rq)
    {
        return [ 
            'fecha_nac' => ['bail', 'nullable', 'date', 'before:today'],
            'apellido_nombres' => ['required', 'max:150'],
            'nro_doc' => ['required', 'numeric', 'digits_between:6,12'],
            function ($attribute, $value, $fail) use ($rq) {
                if (!($rq->input($attribute) == null)) {
                    if (!$rq->id) {
                        $grupo_familiar = grupo_familiar::where("nro_doc", $rq->nro_doc)->first();
                        if (!empty($grupo_familiar)) {
                            $fail("Otro familiar ya esta dado de alta con el mismo nro de DNI");
                        }
                    }
                    $afiliado_empresa = afiliado_empresa::query()
                    ->join('afiliado', 'id', 'afiliado_id')
                    ->where('afiliado_id', $rq->afiliado_id)
                    ->orderByDesc('fecha_ingreso')
                    ->first();
                    if ($afiliado_empresa) {
                        if (empty($afiliado_empresa->fecha_egreso)) {
                            $fail("Error al dar de alta, Ya existe un Afiliado Titular con este dni, el Titular debe estar dado de baja para luego de alta el familiar.");
                        }
                    }
                }
            }
        ];
    }
}
