<?php

namespace App\Http\Controllers\comunes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\parametro;

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
}
