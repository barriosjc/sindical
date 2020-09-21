<?php

namespace App\Http\Controllers\comunes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\parametro;
use App\models\localidad;
use App\models\afiliado;
use App\models\motivo_egreso_sind;

class comunesController extends Controller
{
    public function volver()
    {
        return redirect()->back();
    }

    public function obtener_siguiente(Request $request)
    {
        $param = parametro::where('dato', $request->tipo)->first();
        $nro = 0;
        if ($param != null) {
            $nro = $param->valor + 1;
            $param->valor = $nro;
            $param->save();
        }

        return response()->json(['success' => $nro]);
    }

    public function traer_localidades(int $prov_id) {

        $localidades = localidad::where('provincia_id',$prov_id)->get();

        return $localidades;
    }

    public function traer_afiliado(int $nro_doc){

        $afiliado = afiliado::where('nro_doc', $nro_doc)->first();

        return $afiliado;
    }

    public function traer_motivos_egresos(){
        
        $mot_egr = motivo_egreso_sind::get();

        return $mot_egr;
    }
}
