<?php

namespace App\Http\Controllers;
use App\models\localidad;

use Illuminate\Http\Request;

class comunesController extends Controller
{

    public function traerlocalidades(int $prov_id) {

        $localidades = localidad::where('provincia_id',$prov_id)->get();

        return $localidades;
    }

}
