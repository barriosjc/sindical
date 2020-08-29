<?php

namespace App\Http\Controllers\gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\afiliadosRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

use App\models\afil_estado_ficha;
use Illuminate\Http\Request;
use App\Models\afiliado;
use App\models\tipo_documento;
use App\models\estados_civil;
use App\models\tipos_nacionalidad;
use App\models\provincia;
use App\models\localidad;
use App\models\afil_pregunta;
use App\models\seccional;
use App\models\categoria;
use App\models\empresa;
use App\models\especialidad;
use App\models\obra_social;
use App\models\motivo_egreso_os;
use App\models\motivo_egreso_sind;
use App\models\pregunta;
use App\models\grupo_familiar;
use App\models\afil_documento;
use App\models\parametro;

use Illuminate\Support\Facades\DB;

use Exception;

class AfiliadosController extends Controller
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

    public function nroafilsiguiente()
    {

        $param = parametro::where('dato', 'NRO_AFIL_TIT')->first();
        $nro = 0;
        if ($param != null) {
            $nro = $param->valor + 1;
            $param->valor = $nro;
            $param->save();
        }

        return response()->json(['success' => $nro]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $registro = new afiliado;
        $estados = afil_estado_ficha::get();
        $tipos_documentos = tipo_documento::where('tipo', 'AFI')->get();
        $nacionalidades = tipos_nacionalidad::get();
        $estado_civil = estados_civil::get();
        $provincias = provincia::get();
        $seccionales = seccional::get();
        $especialidades = especialidad::get();
        $obras_sociales = obra_social::get();
        $categorias = categoria::get();
        $empresas = empresa::get();
        $motivos_egresos_os = motivo_egreso_os::get();
        $motivos_egresos_sind = motivo_egreso_sind::get();
        $localidades = null;

        // $localidades = new localidad;

        return view('afiliados.ficha', compact(
            'registro',
            'estados',
            'tipos_documentos',
            'nacionalidades',
            'estado_civil',
            'provincias',
            'localidades',
            'seccionales',
            'categorias',
            'empresas',
            'motivos_egresos_os',
            'motivos_egresos_sind',
            'especialidades',
            'obras_sociales'
        ));
    }

    public function find(Request $request, int $id = null)
    {

        if (!empty($id)) {
            $registro = afiliado::where('id', $id)->first();
        } else 
        if (!empty($request->busdni)) {
            $registro = afiliado::where('nro_doc', $request->busdni)->first();
        } else {
            $registro = afiliado::where('nro_afil_sindical', $request->busnroafil)->first();
        }

        try {
            if ($registro == null) {
                throw new Exception('No se encontro el dato ingresado a buscar, intente con otro dato.');
                // $registro = new afiliado;
                // $localidades = null;
            } else {
                $localidades = localidad::where('id', $registro->localidad_id)->first();
            }
            // dump($registro->localidad_id);
            // dd($localidades); 
            $estados = afil_estado_ficha::get();
            $tipos_documentos = tipo_documento::where('tipo', 'AFI')->get();
            $nacionalidades = tipos_nacionalidad::get();
            $estado_civil = estados_civil::get();
            $provincias = provincia::get();
            $seccionales = seccional::get();
            $especialidades = especialidad::get();
            $obras_sociales = obra_social::get();
            $categorias = categoria::get();
            $empresas = empresa::get();
            $motivos_egresos_os = motivo_egreso_os::get();
            $motivos_egresos_sind = motivo_egreso_sind::get();
            $cant = afil_pregunta::where('afiliado_id', $registro->id)->count();
            $cantidades = ['preguntas' => $cant];
            $cant = grupo_familiar::where('afiliado_id', $registro->id)->count();
            $cantidades['grupo_fam'] = $cant;
            $cant = afil_documento::where('afiliado_id', $registro->id)->where('tipo_documento_id', 11)->count();
            $cantidades['foto'] = $cant;
            $cant = afil_documento::where('afiliado_id', $registro->id)->where('tipo_documento_id', '!=', 11)->count();
            $cantidades['documentos'] = $cant;
            // dump($cant);
            // dd($cantidades);
            // dd($afil_preguntas->pluck('descripcion')->first());
            // $localidades = new localidad;
        } catch (\Exception $e) {

            $mensaje =  $e->getMessage();

            return back()->withErrors(['mensaje' => $mensaje])->withInput();
        }


        return view('afiliados.ficha', compact(
            'cantidades',
            'registro',
            'estados',
            'tipos_documentos',
            'nacionalidades',
            'estado_civil',
            'provincias',
            'localidades',
            'seccionales',
            'categorias',
            'empresas',
            'motivos_egresos_os',
            'especialidades',
            'motivos_egresos_sind',
            'obras_sociales'
        ));
    }

    public function guardar(afiliadosRequest $request)
    {
        // $requestData = new afiliado();
        $requestData = $request->all();
        $requestData['user_last_name'] = Auth::user()->last_name ;
        //   dd($requestData);
        afiliado::updateorcreate(['id' => $request->id], $requestData);

        // return redirect('afiliados.ficha')->with('mensaje', );
        return back()->with(["mensaje" => 'Afiliado creado con éxito!']);
    }

    public function preguntas_index(int $afiliado_id)
    {
        // dd($afiliado_id);
        $preguntas = pregunta::get();
        $afil_preguntas = afil_pregunta::query()
            ->join('preguntas as p', 'p.id', 'afil_preguntas.pregunta_id')
            ->select('p.descripcion', 'respuesta', 'obs', 'pregunta_id', 'afiliado_id', 'afil_preguntas.id', 'pregunta_id')
            ->where('afil_preguntas.afiliado_id', $afiliado_id)
            ->paginate(5);

        return view('afiliados.preguntas', compact('afiliado_id', 'preguntas', 'afil_preguntas'));
    }

    public function preguntas_guardar(Request $request)
    {
        // $requestData = new afil_pregunta();
        $requestData = $request->all();
        //  dd($requestData);
        afil_pregunta::create($requestData);

        // return redirect('afiliados.ficha')->with('mensaje', );
        return back()->with(["mensaje" => 'pregunta y respuesta creado con éxito!']);
    }

    public function preguntas_borrar(int $id)
    {

        $preg = afil_pregunta::find($id);
        $preg->delete();

        return back()->with(["mensaje" => 'pregunta y respuesta borrada con éxito!']);
    }

    public function buscar_index(int $id)
    {

        $estados = afil_estado_ficha::get();
        $nacionalidades = tipos_nacionalidad::get();
        $provincias = provincia::get();
        $seccionales = seccional::get();
        $especialidades = especialidad::get();
        $obras_sociales = obra_social::get();
        $categorias = categoria::get();
        $empresas = empresa::get();
        $motivos_egresos_os = motivo_egreso_os::get();
        $motivos_egresos_sind = motivo_egreso_sind::get();
        $afiliado_id = $id;
        $afiliados = array();

        return view('afiliados.buscar', compact(
            'afiliado_id',
            'estados',
            'nacionalidades',
            'provincias',
            'seccionales',
            'especialidades',
            'obras_sociales',
            'categorias',
            'empresas',
            'motivos_egresos_os',
            'motivos_egresos_afil',
            'afiliados'
        ));
    }

    public function buscar(Request $request)
    {

        $filtro = [];
        if (!empty($request->afil_estado_ficha_id)) {
            $filtro[] = ['afiliados.afil_estado_ficha_id', '=', $request->afil_estado_ficha_id];
        }
        if (!empty($request->apellido_nombres)) {
            $filtro[] = ['afiliados.apellido_nombres', 'like', '%' . $request->apellido_nombres . '%'];
        }
        if (!empty($request->docum_pendiente)) {
            $filtro[] = ['afiliados.docum_pendiente', '<=', $request->docum_pendiente];
        }
        if (!empty($request->docum_entregada)) {
            $filtro[] = ['afiliados.docum_entregada', '<=', $request->docum_entregada];
        }
        if (!empty($request->nacionalidad_id)) {
            $filtro[] = ['afiliados.nacionalidad_id', '=', $request->nacionalidad_id];
        }
        if (!empty($request->provincia_id)) {
            $filtro[] = ['afiliados.provincia_id', '=', $request->provincia_id];
        }
        if (!empty($request->seccional_id)) {
            $filtro[] = ['afiliados.seccional_id', '<=', $request->seccional_id];
        }
        if (!empty($request->empresa_id)) {
            $filtro[] = ['afiliados.empresa_id', '=', $request->empresa_id];
        }
        if (!empty($request->categoria_id)) {
            $filtro[] = ['afiliados.categoria_id', '=', $request->categoria_id];
        }
        if (!empty($request->especialidad_id)) {
            $filtro[] = ['afiliados.especialidad_id', '=', $request->especialidad_id];
        }
        if (!empty($request->fecha_egr_empr)) {
            $filtro[] = ['afiliados.fecha_egr_empr', '<=', $request->fecha_egr_empr];
        }
        if (!empty($request->delegado_hasta)) {
            $filtro[] = ['afiliados.delegado_hasta', '<=', $request->delegado_hasta];
        }
        if (!empty($request->obra_social_id)) {
            $filtro[] = ['afiliados.obra_social_id', '=', $request->obra_social_id];
        }
        if (!empty($request->fecha_egreso_os)) {
            $filtro[] = ['afiliados.fecha_egreso_os', '<=', $request->fecha_egreso_os];
        }
        if (!empty($request->motivo_egreso_os_id)) {
            $filtro[] = ['afiliados.motivo_egreso_os_id', '=', $request->motivo_egreso_os_id];
        }
        if (!empty($request->discapacitado)) {
            $filtro[] = ['afiliados.discapacitado', '=', $request->discapacitado];
        }

        try {
            if (empty($filtro)) {
                if (!$request->has('page')) {
                    throw new Exception('Es obligatorio ingresar por lo menos un dato a buscar');
                }
            }

            // DB::enableQueryLog();

            // no uso estado ficha pero no lo quite de la consulta, si hace falta sacar estado ficha
            $afiliados = afiliado::query()
                ->join('empresas as e', 'e.id', 'afiliados.empresa_id')
                ->join('afil_estado_ficha as ef', 'ef.id', 'afiliados.afil_estado_ficha_id')
                ->select('afiliados.*', 'e.nombre as empresa_nom', 'ef.descripcion as estado_desc')
                ->where($filtro)
                ->orderby('afiliados.apellido_nombres')
                ->paginate(15);
            // $log = DB::getQueryLog();
            // dd($log);
        } catch (\Exception $e) {
            $msg =  $e->getMessage();
            return back()->withErrors(['mensaje' => $msg]);
        }

        return view('afiliados.buscar_resultados', compact('afiliados'));
    }

    public function documentos_index(int $afiliado_id)
    {
        // dd($afiliado_id);
        $tipos_documentos = tipo_documento::where('tipo', 'TIT')->get();
        $afil_documentos = afil_documento::query()
            ->join('tipos_documentos as td', 'td.id', 'afil_documentos.tipo_documento_id')
            ->select('td.descripcion', 'fecha_vencimiento', 'obs', 'tipo_documento_id', 'afiliado_id', 'afil_documentos.id')
            ->where('afil_documentos.afiliado_id', $afiliado_id)
            ->paginate(5);

        return view('afiliados.documentos', compact('afiliado_id', 'tipos_documentos', 'afil_documentos'));
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
            // $path = $request->file('path')->store('public/afiliados/documentacion');
            $path = Storage::disk('uploads')->put('afiliados/documentacion',  $request->file('path'));
            // dd($path);
            $requestData['path'] = $path;
        }
        //  dd($requestData);
        afil_documento::create($requestData);

        // return redirect('afiliados.ficha')->with('mensaje', );
        return back()->with(["mensaje" => 'documentación cargada con éxito!']);
    }

    public function documentos_borrar(int $id)
    {  

        $preg = afil_documento::find($id);
        if (!empty($preg->path)){
            // Storage::delete($preg->path);
        }
        $preg->delete();

        return back()->with(["mensaje" => 'pregunta y respuesta borrada con éxito!']);
    }
    
    public function download(int $id){

        $path = afil_documento::find($id)->path;
        if(!file_exists($path)){
            return back()->withErrors(['mensaje' => "El archivo que intenta descargar no se encuentra almacenado en el servidor."]);
        }
        
        return response()->download(public_path() . '/' . $path);

    }

    public function carnet($id){

        $afiliado = afiliado::find($id);
        $pdf = PDF::loadView('afiliados.carnet', compact('afiliado'));

        return $pdf->download('carnet_' . $afiliado->nro_doc . '.pdf');
    }
}
