<?php

namespace App\Http\Controllers\gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\empresasRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

use App\Models\seccional;
use App\models\tipo_rama_empr;
use App\models\empresa_estado;
use App\models\tipo_actividad_empr;
use App\Models\empresa;
use App\models\tipo_baja_empr;
use App\models\provincia;
use App\models\localidad;
use App\models\afiliado;
use App\models\afiliado_empresa;
use App\models\empr_documento;
use App\models\tipo_documento;

use Illuminate\Support\Facades\DB;

use Exception;

class EmpresasController extends Controller
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
    public function index()
    {
        $registro = new empresa;
        $seccionales = seccional::get();
        $empresas_estados = empresa_estado::get();
        $tipos_rama_empr = tipo_rama_empr::get();
        $provincias = provincia::get();
        $tipos_actividad_empr = tipo_actividad_empr::get();
        $tipos_baja_empr = tipo_baja_empr::get();
        $localidades = null;
        $localidades_adm = null;
        
        $cant_empadronados = 0;

        // $localidades = new localidad;

        return view('empresas.ficha', compact(
            'registro',
            'seccionales',
            'empresas_estados',
            'tipos_rama_empr',
            'provincias',
            'tipos_actividad_empr',
            'tipos_baja_empr',
            'localidades',
            'localidades_adm',
            'cant_empadronados'
        ));
    }

    public function find(Request $request, int $id = null)
    {
        if (!empty($id)) {
            $registro = empresa::where('id', $id)->first();
        } elseif (!empty($request->buscuit)) {
            $registro = empresa::where('cuit',  str_replace("-", "", $request->buscuit))->first();
        } else {
            $registro = empresa::where('cod_empresa', $request->buscodempr)->first();
        }

        try {
            if ($registro == null) {
                throw new Exception('No se encontro el dato ingresado a buscar, intente con otro dato.');
            } else {
                $localidades = localidad::where('id', $registro->localidad_id)->first();
                $localidades_adm = localidad::where('id', $registro->localidad_adm_id)->first();
            }

            $seccionales = seccional::get();
            $empresas_estados = empresa_estado::get();
            $tipos_rama_empr = tipo_rama_empr::get();
            $provincias = provincia::get();
            $tipos_actividad_empr = tipo_actividad_empr::get();
            $tipos_baja_empr = tipo_baja_empr::get();
            $cant = empr_documento::where('empresa_id', $registro->id)->count();
            $cantidades['documentos'] = $cant;
            $cantidades['afiliados'] = afiliado_empresa::where('empresa_id', $registro->id)->count();
            $cant_empadronados = $cantidades['afiliados'];
        } catch (\Exception $e) {
            $mensaje =  $e->getMessage();

            return back()->withErrors(['mensaje' => $mensaje])->withInput();
        }

        return view('empresas.ficha', compact(
            'cantidades',
            'registro',
            'seccionales',
            'empresas_estados',
            'tipos_rama_empr',
            'tipos_actividad_empr',
            'tipos_baja_empr',
            'provincias',
            'localidades',
            'localidades_adm',
            'cant_empadronados'
        ));
    }

    public function guardar(empresasRequest $request)
    {
        // $requestData = new empresa();
        $requestData = $request->all();
        $requestData['user_last_name'] = Auth::user()->last_name ;
        //   dd($requestData);
        empresa::updateorcreate(['id' => $request->id], $requestData);

        // return redirect('empresas.ficha')->with('mensaje', );
        return back()->with(["mensaje" => 'empresa creada o modificada con éxito!']);
    }

    public function buscar_index(int $id)
    {
        $seccionales = seccional::get();
        $empresas_estados = empresa_estado::get();
        $tipos_rama_empr = tipo_rama_empr::get();
        $provincias = provincia::get();
        $tipos_actividad_empr = tipo_actividad_empr::get();
        $tipos_baja_empr = tipo_baja_empr::get();
        $empresa_id = $id;

        return view('empresas.buscar', compact(
            'seccionales',
            'empresas_estados',
            'tipos_rama_empr',
            'provincias',
            'tipos_actividad_empr',
            'tipos_baja_empr',
            'empresa_id'
        ));
    }

    public function buscar(Request $request)
    {
        $filtro = [];
        if (!empty($request->empresa_estado_id)) {
            $filtro[] = ['empresas.empresa_estado_id', '=', $request->empresa_estado_id];
        }
        if (!empty($request->razon_social)) {
            $filtro[] = ['empresas.razon_social', 'like', '%' . $request->razon_social . '%'];
        }
        if (!empty($request->calle)) {
            $filtro[] = ['empresas.calle', 'like', '%' . $request->calle . '%'];
        }
        if (!empty($request->seccional_id)) {
            $filtro[] = ['empresas.seccional_id', '=', $request->seccional_id];
        }
        if (!empty($request->provincia_id)) {
            $filtro[] = ['empresas.provincia_id', '=', $request->provincia_id];
        }
        if (!empty($request->provincia_adm_id)) {
            $filtro[] = ['empresas.provincia_adm_id', '=', $request->provincia_adm_id];
        }
        if (!empty($request->telefono1)) {
            $filtro[] = ['empresas.telefono1', '=', $request->telefono1];
        }
        if (!empty($request->tipo_rama_empr_id)) {
            $filtro[] = ['empresas.tipo_rama_empr_id', '=', $request->tipo_rama_empr_id];
        }
        if (!empty($request->tipo_actividad_empr_id)) {
            $filtro[] = ['empresas.tipo_actividad_empr_id', '=', $request->tipo_actividad_empr_id];
        }
        if (!empty($request->fecha_inicio_actividad)) {
            $filtro[] = ['empresas.fecha_inicio_actividad', '<=', $request->fecha_inicio_actividad];
        }
        if (!empty($request->fecha_baja_ck)) {
            $filtro[] = ['empresas.fecha_baja', '=', null];
        }
        if (!empty($request->fecha_baja)) {
            $filtro[] = ['empresas.fecha_baja', '<=', $request->fecha_baja];
        }
        if (!empty($request->fecha_ult_inspeccion_ck)) {
            $filtro[] = ['empresas.fecha_ult_inspeccion', '=', null];
        }
        if (!empty($request->fecha_ult_inspeccion)) {
            $filtro[] = ['empresas.fecha_ult_inspeccion', '<=', $request->fecha_ult_inspeccion];
        }
        if (!empty($request->tipo_baja_empr_id)) {
            $filtro[] = ['empresas.tipo_baja_empr_id', '=', $request->tipo_baja_empr_id];
        }
        if (!empty($request->novedades)) {
            $filtro[] = ['empresas.novedades', '=', $request->novedades];
        }
        if (!empty($request->obs)) {
            $filtro[] = ['empresas.obs', 'like', '%' . $request->obs . '%'];
        }


        try {
            if (empty($filtro)) {
                if (!$request->has('page')) {
                    throw new Exception('Es obligatorio ingresar por lo menos un dato a buscar');
                }
            }

            // DB::enableQueryLog();

            // no uso estado ficha pero no lo quite de la consulta, si hace falta sacar estado ficha
            $empresas = empresa::query()
                ->leftjoin('tipos_actividad_empr as tae', 'tae.id', 'empresas.tipo_actividad_empr_id')
                ->leftjoin('empresas_estados as ee', 'ee.id', 'empresas.empresa_estado_id')
                ->select('empresas.*', 'tae.descripcion as tipo_actividad', 'ee.descripcion as estado_desc')
                ->where($filtro)
                ->orderby('empresas.razon_social')
                ->paginate(15);
            // $log = DB::getQueryLog();
            // dd($log);
        } catch (\Exception $e) {
            $msg =  $e->getMessage();
            return back()->withErrors(['mensaje' => $msg]);
        }

        return view('empresas.buscar_resultados', compact('empresas'));
    }

    public function documentos_index(int $empresa_id)
    {
        // dd($empresa_id);
        $tipos_documentos = tipo_documento::where('tipo', 'EMP')->get();
        $empr_documentos = empr_documento::where('empr_documentos.empresa_id', $empresa_id)
            ->paginate(5);

        return view('empresas.documentos', compact('empresa_id', 'tipos_documentos', 'empr_documentos'));
    }

    public function documentos_guardar(Request $request)
    {
        $request->validate([
            'tipo_documento_id' => 'required',
            'path' => 'required|file',
            'obs' => 'nullable|string|max:150'
        ]);

        // $requestData = new afil_pregunta();
        $requestData = $request->all();
        if ($request->hasFile('path')) {
            //guarda en documentacion porque documentos entra en conflicto con una route
            // $path = $request->file('path')->store('public/empresas/documentacion');
            $path = Storage::disk('uploads')->put('empresas/documentacion', $request->file('path'));
            // dd($path);
            $requestData['path'] = $path;
        }
        //  dd($requestData);
        empr_documento::create($requestData);

        // return redirect('empresas.ficha')->with('mensaje', );
        return back()->with(["mensaje" => 'documentación cargada con éxito!']);
    }

    public function documentos_borrar(int $id)
    {
        $preg = empr_documento::find($id);
        if (!empty($preg->path)) {
            // Storage::delete($preg->path);
        }
        $preg->delete();

        return back()->with(["mensaje" => 'pregunta y respuesta borrada con éxito!']);
    }
    
    public function download(int $id)
    {
        $path = empr_documento::find($id)->path;
        if (!file_exists($path)) {
            return back()->withErrors(['mensaje' => "El archivo que intenta descargar no se encuentra almacenado en el servidor."]);
        }
        
        return response()->download(public_path() . '/' . $path);
    }
}
