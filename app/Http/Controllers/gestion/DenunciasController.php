<?php

namespace App\Http\Controllers\gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\denunciasRequest;
use App\models\afiliado;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

use Illuminate\Http\Request;
use App\Models\denuncia;
use App\models\den_tipo_denuncia;
use App\models\den_ministerio;
use App\models\den_tipo_movimiento;
use App\models\denuncia_det;
use App\models\den_documento_cab;
use App\models\den_documento_det;
use App\models\tipo_documento;


use Exception;

class DenunciasController extends Controller
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
    public function index(int $denuncia_id = null, int $id = null)
    {
        if (empty($id)) {
            $registro = new denuncia;
        } else {
            $registro = denuncia::where('id', $id)->first();
        }

        $tipos_denuncias = den_tipo_denuncia::get();
        $tipos_movimientos = den_tipo_movimiento::get();
        $ministerios = den_ministerio::get();
        $tipo_movimiento_desc = null;

        return view('denuncias.ficha', compact(
            'registro',
            'tipos_denuncias',
            'tipos_movimientos',
            'ministerios',
            'tipo_movimiento_desc'
        ));
    }

    public function find(Request $request, int $id = null)
    {
        $registro = null;
        if (!empty($id)) {
            $registro = denuncia::where('id', $id)->first();
        } else 
        if (!empty($request->busnrodni)) {
            $registro = denuncia::query()
                ->join('denuncias_det as det', 'det.denuncia_id', 'denuncias.id' )
                ->leftjoin('afiliados as a', 'a.id', 'afiliado_id')
                ->select('denuncias.*', 'nro_doc as nro_dni', 'apellido_nombres', 'telefono1' , 
                        DB::raw('CONCAT(calle," ",ifnull(calle_nro, "")," ",ifnull(calle_piso, "")) as direccion'),
                        'det.tipo_movimiento_id', 'det.obs')
                ->where('a.nro_doc', $request->busnrodni)
                ->orderby('det.fecha', 'asc')
                ->first();               
        } else {
            $registro = denuncia::query()
                ->join('denuncias_det as det', 'det.denuncia_id', 'denuncias.id' )
                ->leftjoin('afiliados as a', 'a.id', 'afiliado_id')
                ->select('denuncias.*', 'nro_doc as nro_dni', 'apellido_nombres', 'telefono1' , 
                        DB::raw('CONCAT(calle," ",ifnull(calle_nro, "")," ",ifnull(calle_piso, "")) as direccion'),
                        'det.tipo_movimiento_id', 'det.obs')
                ->where('numero', $request->busdenuncia)
                ->orderby('det.fecha', 'asc')
                ->first();
        }
// dd($registro);
        try {
            if ($registro == null) {
                throw new Exception('No se encontro el dato ingresado a buscar, intente con otro dato.');
            }
        } catch (\Exception $e) {

            $mensaje =  $e->getMessage();

            return back()->withErrors(['mensaje' => $mensaje])->withInput();
        }

        $tipos_denuncias = den_tipo_denuncia::get();
        $tipos_movimientos = den_tipo_movimiento::get();
        $ministerios = den_ministerio::get();
        $cantidades['documentos'] = den_documento_cab::where('denuncia_id', $registro->id)->count(); 
        $tipo_movimiento_desc = denuncia_det::where('denuncia_id', $registro->id)->orderby('fecha','desc')->first()->tipos_movimientos->descripcion;
        $denuncias_det = denuncia_det::where('denuncia_id', $registro->id)->orderby('fecha', 'asc')->paginate(5);

        return view('denuncias.ficha', compact(
            'registro',
            'tipos_denuncias',
            'tipos_movimientos',
            'ministerios',
            'cantidades',
            'denuncias_det',
            'tipo_movimiento_desc'
        ));
    }

    public function buscar_index()
    {
        $tipos_documentos = tipo_documento::where('tipo', 'DEN')->get();
        $tipos_denuncias = den_tipo_denuncia::get();
        $tipos_movimientos = den_tipo_movimiento::get();
        $ministerios = den_ministerio::get();

        return view('denuncias.buscar', compact('tipos_denuncias', 'tipos_documentos', 'tipos_movimientos','ministerios'));
    }

    public function buscar(Request $request)
    {

        $filtro = [];
        $filtro_det = [];

        if (!empty($request->nombre)) {
            $filtro[] = ['v_ult_denuncias.nombre', 'like', '%' . $request->nombre . '%'];
        }
        if (!empty($request->tipo_denuncia_id)) {
            $filtro[] = ['v_ult_denuncias.tipo_denuncia_id', '=', $request->tipo_denuncia_id];
        }
        if (!empty($request->ministerio_id)) {
            $filtro[] = ['v_ult_denuncias.ministerio_id', '=', $request->ministerio_id];
        }
        if (!empty($request->fecha_ingreso)) {
            $filtro[] = ['v_ult_denuncias.fecha_ingreso', '<=', $request->fecha_ingreso];
        }
        if (!empty($request->direccion)) {
            $filtro[] = ['v_ult_denuncias.direccion', 'like', '%' . $request->direccion . '%'];
        }
        if (!empty($request->empresa)) {
            $filtro[] = ['v_ult_denuncias.empresa', 'like', '%' . $request->empresa . '%'];
        }
        if (!empty($request->cuit)) {
            $filtro[] = ['v_ult_denuncias.cuit', '=', $request->cuit];
        }
        if (!empty($request->numero_expediente)) {
            $filtro[] = ['v_ult_denuncias.numero_expediente', '=', $request->numero_expediente];
        }        
        if (!empty($request->tomo_denuncia)) {
            $filtro[] = ['v_ult_denuncias.tomo_denuncia', 'like', '%' . $request->tomo_denuncia . '%'];
        }
        if (!empty($request->tipo_movimiento_id)) {
            $filtro[] = ['v_ult_denuncias.tipo_movimiento_id', '=', $request->tipo_movimiento_id];
        }


        try {
            if (empty($filtro)) {
                if (!$request->has('page')) {
                    throw new Exception('Es obligatorio ingresar por lo menos un dato a buscar');
                }
            }

            //  DB::enableQueryLog();

            $denuncias = DB::table('v_ult_denuncias')
            ->where($filtro)
            ->orderby('nombre')
            ->paginate(15);

            //  dd(DB::getQueryLog());
            //  dd($denuncias);
        } catch (\Exception $e) {
            $msg =  $e->getMessage();
            return back()->withErrors(['mensaje' => $msg]);
        }

        return view('denuncias.buscar_resultados', compact('denuncias'));
    }

    public function guardar(denunciasRequest $request)
    {
        // $requestData = new denuncia();
        $requestData = $request->all();
        $requestData['user_last_name'] = Auth::user()->last_name;

        // $afil = afiliado::where('nro_doc', $request->nro_dni)->first();

        $den = denuncia::updateorcreate(['id' => $request->id], $requestData);

        //--------------------------------------------------------------------
        $det['denuncia_id'] = $den->id;
        $det['fecha'] = $request->fecha_ingreso;       
        $det['tipo_movimiento_id'] = $request->tipo_movimiento_id;
        $det['obs'] = $request->obs;
        $det['user_last_name'] = Auth::user()->last_name;
        // busco el primer detalle si existe lo modifico

        $detid = 0;
        $primerdet = denuncia_det::where('denuncia_id', $den->id)->first();
        if (!empty($primerdet)) {
            $detid = $primerdet->id;
        }
        denuncia_det::updateorcreate(['id' => $detid], $det);

        return back()->with(["mensaje" => 'denuncia creada con éxito!']);
    }


    public function documentos_index(int $denuncia_id)
    {
        $tipos_documentos = tipo_documento::where('tipo', 'DEN')->get();
        $documentos = den_documento_cab::where('denuncia_id', $denuncia_id)
            ->with('documentos_det')
            ->paginate(5);

        return view('denuncias.documentos', compact('denuncia_id', 'tipos_documentos', 'documentos'));
    }

    public function documentos_guardar(Request $request)
    {
        $request->validate([
            'tipo_documento_id' => 'required',
            'hoja' => 'required|max:20',
            'path' => 'required|file',
            'fecha_vencimiento' => 'nullable|date',
            'obs' => 'nullable|string|max:150'
        ]);

        $requestData = $request->all();
        if ($request->hasFile('path')) {
            $path = Storage::disk('uploads')->put('denuncia/documentacion',  $request->file('path'));
            $requestData['path'] = $path;
        }
        //  dd($requestData);
        $denuncia = den_documento_cab::where('denuncia_id', $request->denuncia_id)
            ->where('tipo_documento_id', $request->tipo_documento_id)
            ->first();
        if(empty($denuncia)){
            $denuncia = den_documento_cab::create($requestData);
        }
        $requestData['documento_cab_id'] = $denuncia->id;
        $requestData['user_last_name'] = Auth::user()->last_name;
        den_documento_det::create($requestData);


        // return redirect('denuncias.ficha')->with('mensaje', );
        return back()->with(["mensaje" => 'documentación cargada con éxito!']);
    }

    public function documentos_borrar(int $id)
    {

        $preg = den_documento_cab::find($id);
        if (!empty($preg->path)) {
            // Storage::delete($preg->path);
        }
        $preg->delete();

        return back()->with(["mensaje" => 'pregunta y respuesta borrada con éxito!']);
    }

    public function download(int $id)
    {

        $path = den_documento_cab::find($id)->path;
        if (!file_exists($path)) {
            return back()->withErrors(['mensaje' => "El archivo que intenta descargar no se encuentra almacenado en el servidor."]);
        }
        return response()->download(public_path() . '/' . $path);
    }

}
