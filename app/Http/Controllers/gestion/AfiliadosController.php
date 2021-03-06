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
use App\Models\afiliado_empresa;
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $registro = new afiliado();
        $afiliado_empresa = new afiliado_empresa();
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

        return view(
            'afiliados.ficha',
            compact(
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
                'obras_sociales',
                'afiliado_empresa'
            )
        );
    }

    public function find(Request $request, int $id = null)
    {
        if (!empty($id)) {
            $registro = afiliado::where('id', $id)->first();
        } elseif (!empty($request->busdni)) {
            $registro = afiliado::where('nro_doc', $request->busdni)->first();
        } else {
            $registro = afiliado::where(
                'nro_afil_sindical',
                $request->busnroafil
            )->first();
        }

        try {
            if ($registro == null) {
                throw new Exception(
                    'No se encontro el dato ingresado a buscar, intente con otro dato.'
                );
            } else {
                $localidades = localidad::where(
                    'id',
                    $registro->localidad_id
                )->first();
            }

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
            $afiliado_empresa = afiliado_empresa::where('afiliado_id', $registro->id)
                ->orderByDesc('fecha_ingreso')
                ->first();
            //  dd( $afiliado_empresa);
            // exit;
            $cant = afil_pregunta::where('afiliado_id', $registro->id)->count();
            $cantidades = ['preguntas' => $cant];
            $cant = grupo_familiar::where('afiliado_id', $registro->id)->count();
            $cantidades['grupo_fam'] = $cant;
            $cant = afil_documento::where('afiliado_id', $registro->id)
                ->where('tipo_documento_id', 11)
                ->count();
            $cantidades['foto'] = $cant;
            $cant = afil_documento::where('afiliado_id', $registro->id)
                ->where('tipo_documento_id', '!=', 11)
                ->count();
            $cantidades['documentos'] = $cant;
            $cant = afiliado_empresa::where(
                'afiliado_id',
                $registro->id
            )->count();
            $cantidades['empresas'] = $cant;
        } catch (\Exception $e) {
            $mensaje = $e->getMessage();

            return back()
                ->withErrors(['mensaje' => $mensaje])
                ->withInput();
        }

        return view(
            'afiliados.ficha',
            compact(
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
                'obras_sociales',
                'afiliado_empresa',
                'afiliado_empresa'
            )
        );
    }

    public function guardar(afiliadosRequest $request)
    {
        //guardo datos del afiliado
        $requestData = $request->all();
        $result = afiliado::updateorcreate(['id' => $request->id], $requestData);
        //guardo datos de afiliado_empresas
        $requestData['user_last_name'] = Auth::user()->last_name;
        $requestData['afiliado_id'] = $result->id;
        afiliado_empresa::updateorcreate(['id' => $request->afiliado_empresa_id], $requestData);


        return back()->with([
            'mensaje' => 'Afiliado creado o actualizado con éxito!',
        ]);
    }

    public function preguntas_index(int $afiliado_id)
    {
        // dd($afiliado_id);
        $preguntas = pregunta::get();
        $afil_preguntas = afil_pregunta::query()
            ->join('preguntas as p', 'p.id', 'afil_preguntas.pregunta_id')
            ->select(
                'p.descripcion',
                'respuesta',
                'obs',
                'pregunta_id',
                'afiliado_id',
                'afil_preguntas.id',
                'pregunta_id'
            )
            ->where('afil_preguntas.afiliado_id', $afiliado_id)
            ->paginate(5);

        return view(
            'afiliados.preguntas',
            compact('afiliado_id', 'preguntas', 'afil_preguntas')
        );
    }

    public function preguntas_guardar(Request $request)
    {
        $requestData = $request->all();

        afil_pregunta::create($requestData);

        return back()->with([
            'mensaje' => 'pregunta y respuesta creado con éxito!',
        ]);
    }

    public function preguntas_borrar(int $id)
    {
        $preg = afil_pregunta::find($id);
        $preg->delete();

        return back()->with([
            'mensaje' => 'pregunta y respuesta borrada con éxito!',
        ]);
    }

    public function buscar_index(int $id = null)
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
        $afiliados = [];

        return view(
            'afiliados.buscar',
            compact(
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
                'motivos_egresos_sind',
                'afiliados'
            )
        );
    }

    public function buscar(Request $request, int $empresa_id = null)
    {
        $filtro = [];
        if (!empty($request->afil_estado_ficha_id)) {
            $filtro[] = [
                'afiliados.afil_estado_ficha_id',
                '=',
                $request->afil_estado_ficha_id,
            ];
        }
        if (!empty($request->apellido_nombres)) {
            $filtro[] = [
                'afiliados.apellido_nombres',
                'like',
                '%' . $request->apellido_nombres . '%',
            ];
        }
        if (!empty($request->docum_pendiente)) {
            $filtro[] = [
                'afiliados.docum_pendiente',
                '<=',
                $request->docum_pendiente,
            ];
        }
        if (!empty($request->docum_entregada)) {
            $filtro[] = [
                'afiliados.docum_entregada',
                '<=',
                $request->docum_entregada,
            ];
        }
        if (!empty($request->nacionalidad_id)) {
            $filtro[] = [
                'afiliados.nacionalidad_id',
                '=',
                $request->nacionalidad_id,
            ];
        }
        if (!empty($request->provincia_id)) {
            $filtro[] = ['afiliados.provincia_id', '=', $request->provincia_id];
        }
        if (!empty($request->seccional_id)) {
            $filtro[] = [
                'afiliados.seccional_id',
                '<=',
                $request->seccional_id,
            ];
        }
        if (!empty($request->empresa_id)) {
            $filtro[] = ['afiliados.empresa_id', '=', $request->empresa_id];
        }
        if (!empty($empresa_id)) {
            $filtro[] = ['afiliados.empresa_id', '=', $empresa_id];
        }
        if (!empty($request->categoria_id)) {
            $filtro[] = ['afiliados.categoria_id', '=', $request->categoria_id];
        }
        if (!empty($request->especialidad_id)) {
            $filtro[] = [
                'afiliados.especialidad_id',
                '=',
                $request->especialidad_id,
            ];
        }
        if (!empty($request->fecha_egreso_ck)) {
            $filtro[] = ['afiliados.fecha_egreso', '=', null];
        }
        if (!empty($request->fecha_egreso)) {
            $filtro[] = [
                'afiliados.fecha_egreso',
                '<=',
                $request->fecha_egreso,
            ];
        }
        if (!empty($request->fecha_egr_empr_ck)) {
            $filtro[] = ['afiliados.fecha_egr_empr', '=', null];
        }
        if (!empty($request->fecha_egr_empr)) {
            $filtro[] = [
                'afiliados.fecha_egr_empr',
                '<=',
                $request->fecha_egr_empr,
            ];
        }
        if (!empty($request->delegado_hasta)) {
            $filtro[] = [
                'afiliados.delegado_hasta',
                '<=',
                $request->delegado_hasta,
            ];
        }
        if (!empty($request->obra_social_id)) {
            $filtro[] = [
                'afiliados.obra_social_id',
                '=',
                $request->obra_social_id,
            ];
        }
        if (!empty($request->fecha_egreso_os)) {
            $filtro[] = [
                'afiliados.fecha_egreso_os',
                '<=',
                $request->fecha_egreso_os,
            ];
        }
        if (!empty($request->motivo_egreso_os_id)) {
            $filtro[] = [
                'afiliados.motivo_egreso_os_id',
                '=',
                $request->motivo_egreso_os_id,
            ];
        }
        if (!empty($request->discapacitado)) {
            $filtro[] = [
                'afiliados.discapacitado',
                '=',
                $request->discapacitado,
            ];
        }

        try {
            if (empty($filtro)) {
                if (!$request->has('page')) {
                    throw new Exception(
                        'Es obligatorio ingresar por lo menos un dato a buscar'
                    );
                }
            }

            // DB::enableQueryLog();

            // no uso estado ficha pero no lo quite de la consulta, si hace falta sacar estado ficha
            $afiliados = afiliado::query()
                ->leftjoin('empresas as e', 'e.id', 'afiliados.empresa_id')
                ->leftjoin(
                    'afil_estado_ficha as ef',
                    'ef.id',
                    'afiliados.afil_estado_ficha_id'
                )
                ->select(
                    'afiliados.*',
                    'e.razon_social as empresa_nom',
                    'ef.descripcion as estado_desc'
                )
                ->where($filtro)
                ->orderby('afiliados.apellido_nombres')
                ->paginate(15);
            // $log = DB::getQueryLog();
            // dd($log);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return back()->withErrors(['mensaje' => $msg]);
        }

        return view('afiliados.buscar_resultados', compact('afiliados'));
    }

    public function documentos_index(int $afiliado_id)
    {
        // dd($afiliado_id);
        $tipos_documentos = tipo_documento::where('tipo', 'TIT')->get();
        $afil_documentos = afil_documento::query()
            ->join(
                'tipos_documentos as td',
                'td.id',
                'afil_documentos.tipo_documento_id'
            )
            ->select(
                'td.descripcion',
                'fecha_vencimiento',
                'obs',
                'tipo_documento_id',
                'afiliado_id',
                'afil_documentos.id'
            )
            ->where('afil_documentos.afiliado_id', $afiliado_id)
            ->paginate(5);

        return view(
            'afiliados.documentos',
            compact('afiliado_id', 'tipos_documentos', 'afil_documentos')
        );
    }

    public function documentos_guardar(Request $request)
    {
        $request->validate([
            'tipo_documento_id' => 'required',
            'path' => 'required|file',
            'obs' => 'nullable|string|max:150',
        ]);

        // $requestData = new afil_pregunta();
        $requestData = $request->all();
        if ($request->hasFile('path')) {
            //guarda en documentacion porque documentos entra en conflicto con una route
            // $path = $request->file('path')->store('public/afiliados/documentacion');
            $path = Storage::disk('uploads')->put(
                'afiliados/documentacion',
                $request->file('path')
            );
            // dd($path);
            $requestData['path'] = $path;
        }
        //  dd($requestData);
        afil_documento::create($requestData);

        // return redirect('afiliados.ficha')->with('mensaje', );
        return back()->with(['mensaje' => 'documentación cargada con éxito!']);
    }

    public function documentos_borrar(int $id)
    {
        $preg = afil_documento::find($id);
        if (!empty($preg->path)) {
            // Storage::delete($preg->path);
        }
        $preg->delete();

        return back()->with([
            'mensaje' => 'pregunta y respuesta borrada con éxito!',
        ]);
    }

    public function download(int $id)
    {
        $path = afil_documento::find($id)->path;
        if (!file_exists($path)) {
            return back()->withErrors([
                'mensaje' =>
                    'El archivo que intenta descargar no se encuentra almacenado en el servidor.',
            ]);
        }

        return response()->download(public_path() . '/' . $path);
    }

    public function carnet($id)
    {
        $afiliado = afiliado::query()
            ->join('afil_documentos as d', 'd.afiliado_id', 'afiliados.id')
            ->join('seccionales as s', 's.id', 'afiliados.seccional_id')
            ->select('afiliados.*', 'd.path', 's.descripcion')
            ->where('d.tipo_documento_id', 11)
            ->first();

        $pdf = PDF::loadView('afiliados.carnet', compact('afiliado'));

        return $pdf->download('carnet_' . $afiliado->nro_doc . '.pdf');
        // return view('afiliados.carnet', compact('afiliado'));
    }

    // --------------------------------------------------------------------------------------------------------
    public function empresas_index(int $afiliado_id, int $afil_emp_id = null)
    {
        $afil_emp = $afil_emp_id == null ? new afiliado_empresa : afiliado_empresa::where('id', $afil_emp_id)->first();
        // dd($afil_emp);
        $seccionales = seccional::get();
        $especialidades = especialidad::get();
        $categorias = categoria::get();
        $empresas = empresa::get();
        $motivos_egresos_sind = motivo_egreso_sind::get();
        $afiliado = afiliado::select('apellido_nombres', 'nro_doc')
            ->where('id', $afiliado_id)
            ->first();
        $afiliado_nombre =
            $afiliado->apellido_nombres . ' - ' . $afiliado->nro_doc;
        $empresas_afil = afiliado_empresa::query()
        ->join('empresas as e', 'e.id', 'empresa_id')
        ->join('seccionales as s', 's.id', 'afiliados_empresas.seccional_id')
        ->leftjoin('motivos_egresos_sind as me', 'me.id', 'motivo_egreso_id')
        ->select('afiliados_empresas.*', 's.descripcion as sec_desc', 'e.razon_social', 'me.descripcion as mot_desc')
        ->where('afiliado_id', $afiliado_id)
        ->orderBy('afiliados_empresas.fecha_ingreso')
        ->paginate(5);

        return view(
            'afiliados.empresas',
            compact(
                'afil_emp',
                'afiliado_id',
                'seccionales',
                'especialidades',
                'categorias',
                'empresas',
                'motivos_egresos_sind',
                'afiliado_nombre',
                'empresas_afil'
            )
        );
    }

    public function empresas_guardar(Request $request)
    {
        dd('entro por aca');

        $request->validate([
            'seccional_id' => 'required',
            'empresa_id' => 'required',
            'categoria_id' => 'required',
            'especialidad_id' => 'required',
            'fecha_ingreso' => ['bail', 'required','required_with:fecha_egreso', 'date', 'before_or_equal:today'],
            'motivo_egreso_id' => 'required_with:fecha_egreso',
            'fecha_ing_empr' => ['bail', 'required','required_with:fecha_egr_empr', 'date', 'before_or_equal:today'],
            'delegado_desde' => ['bail', 'nullable','required_with:delegado_hasta', 'date', 'before_or_equal:today'],
        ]);

        if (!empty($request->fecha_egreso)) {
            $request->validate(['fecha_egreso' => ['required_with:motivo_egreso_id', 'date', 'before_or_equal:fecha_ingreso']]);
        }
        if (!empty($request->fecha_egr_empr)) {
            $request->validate(['fecha_egr_empr' => [ 'date', 'before_or_equal:fecha_ing_empr']]);
        }
        if (!empty($request->delegado_hasta)) {
            $request->validate(['delegado_hasta' => [ 'date', 'before_or_equal:delegado_desde']]);
        }

        // $requestData = $request->all();
        $afi_emp = new afiliado_empresa;
        //  dd( $request->all());
        $afi_emp->afiliado_id = $request->afiliado_id;
        $afi_emp->empresa_id = $request->empresa_id;
        $afi_emp->seccional_id = $request->seccional_id;
        $afi_emp->categoria_id = $request->categoria_id;
        $afi_emp->especialidad_id = $request->especialidad_id;
        $afi_emp->fecha_ingreso = $request->fecha_ingreso;
        $afi_emp->fecha_egreso = $request->fecha_egreso;
        $afi_emp->motivo_egreso_id = $request->motivo_egreso_id;
        $afi_emp->fecha_ing_empr = $request->fecha_ing_empr;
        $afi_emp->fecha_egr_empr = $request->fecha_egr_empr;
        $afi_emp->delegado_desde = $request->delegado_desde;
        $afi_emp->delegado_hasta = $request->delegado_hasta;
        $afi_emp->user_last_name =  Auth::user()->last_name;

        $afi_emp->save();

        return back()->with([
            'mensaje' => 'Empresa asignada al afiliado con éxito!',
        ]);
    }

    public function empresas_borrar(int $id)
    {
        $preg = afiliado_empresa::find($id);

        $preg->delete();

        return back()->with([
            'mensaje' => 'Empresa asignada al afiliado borrada con éxito!',
        ]);
    }
}