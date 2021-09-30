<?php

namespace App\Http\Controllers\gestion;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Imports\PadronImport;
use App\models\padronuom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// use App\Models\padronuom;



use Exception;

class SecretariadoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function importar()
    {
        ini_set('memory_limit', '-1');
        // dump('memory_limit');
        // dump(ini_get('upload_max_filesize'));
        // dd(ini_get('post_max_size'));

        return view("secretariado/importar");
    }

    public function guardar(Request $request)
    {
        // ini_set('memory_limit', '-1');
        // set_time_limit (1800);

        // $request->validate([
        //     'path' => 'required|file'
        // ]);
        // // |mimes:csv
        // // dd($request->path);
        // // DB::beginTransaction();
        // $dato = '';
        // try {

        //     $archivo = $request->file('path');
        //     $collection = (new FastExcel)->import($archivo);

        //     foreach ($collection as $line) {
        //         if (empty($line['B'])) {
        //             break;
        //         }
        //         $dato = $line;
        //         $dir_nro = (string) $line['N'];
        //         $dir_piso = (string) $line['O'];
        //         $dir_depto = (string) $line['P'];

        //         padronuom::updateOrCreate(
        //             ['cuil_fam' => $line['E']],
        //             [
        //             'cuit_empr' => $line['B'],
        //             'cuil_titu' => $line['C'],
        //             'parentesco_id' => $line['D'],
        //             'cuil_fam' => $line['E'],
        //             'tipo_doc' => $line['F'],
        //             'nro_doc' => $line['G'],
        //             'nombre' => $line['H'],
        //             'sexo' => $line['I'],
        //             'est_civil' => $line['J'],
        //             'fecha_nac' => substr($line['K'], -4, 4) . '-' . substr($line['K'], -6, 2) . '-' . substr('0'. $line['K'], -8, 2),
        //             'nacionalidad_id' => $line['L'],
        //             'direccion' => $line['M'],
        //             'direccion_nro' =>   substr($dir_nro, 0, 10),
        //             'direccion_piso' =>  substr($dir_piso, 0, 10),
        //             'direccion_depto' => substr($dir_depto, 0, 10),
        //             'localidad' => $line['Q'],
        //             'cod_postal' => $line['R'],
        //             'provincia_id' => $line['S'],
        //             'telefono' => $line['U'],
        //             'discapacitado' => $line['W'],
        //             'tipo_afiliado_id' => $line['X'],
        //             'fecha_alta_os' => substr($line['Y'], -4, 4) . '-' . substr($line['Y'], -6, 2) . '-' . substr('0'. $line['Y'], -8, 2),
        //             'seccional_id' => $line['AB'],
        //             'seccional' => $line['AC'],
        //             'ult_pago' => $line['AE'],
        //             'estado' => 'A'
        //         ]);

        //     }

        //     // DB::commit();
        // } catch (\Exception $e) {
        //     $msg =  $e->getMessage() . '//' . implode('|', $dato);
        //     // DB::rollback();

        //     return back()->withErrors(['mensaje' => $msg])->withInput();
        // }
        return back()->withErrors(["Proceso en desarrollo, no disponible actualmente."]);
    }

    public function informes(Request $request)
    {
        $result = padronuom::difAfiliadoPadron();
        

    }

    public function informesver()
    {
    }
}
