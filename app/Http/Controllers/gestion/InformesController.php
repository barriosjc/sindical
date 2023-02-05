<?php

namespace App\Http\Controllers\gestion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exporter;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Facades\Excel;

class InformesController extends Controller
{
    public function index()
    {
        $informes = ["afiliados" => "Padrón de afiliados", "empresas" => "Padrón de empresas", "familiares" => "Afiliados con grupo familiar", "escolaridad" => "listado de afiliados que se le entregó utiles"];

        return view("informes.padrones", compact("informes"));
    }

    public function generar(request $request)
    {

        switch ($request->informe) {
            case "afiliados":
                $clase = new \App\Exports\AfiliadosExport;
                break;
            case "empresas":
                $clase = new \App\Exports\EmpresasExport;
                break;
            case "familiares":
                $clase = new \App\Exports\FamiliaresExport;
                break;
            case "escolaridad":
                $clase = new \App\Exports\EscolaridadExport;
                break;
        }

        return Excel::download($clase, 'padron_'.$request->informe.'.xlsx');
    }
}