<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\models\empresa;

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
    public function rules(Request $rq)
    {
        return [  //   'sexo' => ['required'],
            'fecha_inicio_actividad' => ['bail', 'required', 'date', 'before_or_equal:today'],            
            'fecha_alta' => ['bail', 'required', 'date', 'before_or_equal:today'],            
            'seccional_id' => ['required'],
            'email' => ['required', 'email:rfc,dns'],   
            'calle' => ['required'],            
            'calle_nro' => ['required','digits_between:1,10'],
            'provincia_id' => ['required'],
            'localidad_id' => ['required'],
            'telefono1' => ['required'],   
            'empresa_estado_id' => ['required'],
            'razon_social' => ['bail', 'required', 'max:150'],
            'cod_empresa' => ['required', 'numeric', 'digits_between:2,12'],
            'cuit' => ['required', 'numeric', 'digits:11'],
            'empresa_estado_id' => ['required', 'numeric'],
            'cod_empresa' => [
                function ($attribute, $value, $fail) use ($rq) {
                    if (!($rq->input($attribute) == null)) {
                        if (!$rq->id) {
                            $empresa = empresa::where("cod_empresa", $rq->cod_empresa)->first();
                            if (!empty($empresa)) {
                                $fail("Otro Empresa ya esta dada de alta con el mismo Código de empresa, debe ingresar un nro distinto. ");
                            }
                        }
                    }
                }
            ],
        ];
    }
}
