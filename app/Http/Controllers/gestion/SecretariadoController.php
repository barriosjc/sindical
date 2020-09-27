<?php

namespace App\Http\Controllers\gestion;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Imports\PadronImport;
use App\models\padronuom;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
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
        ini_set('memory_limit', '-1');

        $request->validate([
            'path' => 'required|file|mimes:xlsx'
        ]);
        // dd($request->path);
        // DB::beginTransaction();
        try {

            $archivo = $request->file('path');
            // $padron = (new FastExcel)->import($archivo, function ($line) {

            //     return padronuom::create([
            //         'cuit_empr' => $line['B'],
            //         'cuil_titu' => $line['C'],
            //         'cuil_fam' => $line['E'],
            //         'tipo_doc' => $line['F'],
            //         'nro_doc' => $line['G'],
            //         'nombre' => $line['H'],
            //         'sexo' => $line['I']
            //     ]);
            // });
            $collection = (new FastExcel)->import($archivo);

            foreach ($collection as $line) {
                if (empty($line['B'])) {
                    break;
                }
                padronuom::create([
                    'cuit_empr' => $line['B'],
                    'cuil_titu' => $line['C'],
                    'cuil_fam' => $line['E'],
                    'tipo_doc' => $line['F'],
                    'nro_doc' => $line['G'],
                    'nombre' => $line['H'],
                    'sexo' => $line['I']
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            $msg =  $e->getMessage();
            DB::rollback();

            return back()->withErrors(['mensaje' => $msg])->withInput();
        }
        return back()->with("mensaje", "se importaron correctamente los datos");
    }

    public function informes()
    {
    }

    public function informesver()
    {
    }
}
