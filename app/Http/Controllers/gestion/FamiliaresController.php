<?php

namespace App\Http\Controllers\gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\familiaresRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\afiliado;
use App\Models\grupo_familiar;
use App\models\tipo_documento;
use App\models\estados_civil;
use App\models\tipos_nacionalidad;
use App\models\provincia;
use App\models\localidad;
use App\models\motivo_egreso_sind;
use App\models\gf_documento;
use App\models\tipo_parentesco;
use App\models\tipo_material;
use App\models\gf_escolaridad;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FamiliaresController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $name_img;

    public function __construct()
    {
        $this->middleware('auth');
        $this->name_img =  'foto_' .  md5("foto") . '.png';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(int $afiliado_id = null, int $id = null)
    {

        if (empty($id)) {
            $registro = new grupo_familiar;
            $localidades = null;
        } else {
            $registro = grupo_familiar::where('id', $id)->first();
            $localidades = localidad::find($registro->localidad_id);
        }

        $grupo_familiar = grupo_familiar::where('afiliado_id', $afiliado_id)->with('tipos_parentescos')->get();
        $motivos_egresos_sind = motivo_egreso_sind::get();
        $tipos_documentos = tipo_documento::where('tipo', 'AFI')->get();
        $nacionalidades = tipos_nacionalidad::get();
        $estado_civil = estados_civil::get();
        $provincias = provincia::get();
        $tipos_parentescos = tipo_parentesco::get();
        $titular = afiliado::find($afiliado_id);
        $registro->nro_grupo_fam = $titular->nro_afil_sindical . '/00';
        $titular = 'Titular: ' . $titular->apellido_nombres . ' / DNI: ' . $titular->nro_doc;

        $cant = gf_documento::where('grupo_familiar_id', $registro->id)->where('tipo_documento_id', 11)->count();
        $cantidades = ['foto' => $cant];
        $cant = gf_documento::where('grupo_familiar_id', $registro->id)->where('tipo_documento_id', '!=', 11)->count();
        $cantidades['documentos'] = $cant;
        // dd($afil_preguntas->pluck('descripcion')->first());
        // $localidades = new localidad;

        return view('familiares.ficha', compact(
            'grupo_familiar',
            'afiliado_id',
            'titular',
            'registro',
            'motivos_egresos_sind',
            'tipos_documentos',
            'nacionalidades',
            'estado_civil',
            'provincias',
            'localidades',
            'tipos_parentescos',
            'cantidades'
        ));
    }

    public function buscar_index(int $id)
    {

        $nacionalidades = tipos_nacionalidad::get();
        $provincias = provincia::get();
        $motivos_egresos_sind = motivo_egreso_sind::get();
        $afiliado_id = $id;
        $tipos_parentescos = tipo_parentesco::get();
        $afiliados = array();

        return view('familiares.buscar', compact(
            'afiliado_id',
            'nacionalidades',
            'provincias',
            'motivos_egresos_sind',
            'afiliados',
            'tipos_parentescos'
        ));
    }

    public function buscar(Request $request)
    {

        $filtro = [];

        if (!empty($request->apellido_nombres)) {
            $filtro[] = ['grupo_familiar.apellido_nombres', 'like', '%' . $request->apellido_nombres . '%'];
        }
        if (!empty($request->nro_doc)) {
            $filtro[] = ['grupo_familiar.nro_doc', '=', $request->nro_doc];
        }
        if (!empty($request->docum_pendiente)) {
            $filtro[] = ['grupo_familiar.docum_pendiente', '<=', $request->docum_pendiente];
        }
        if (!empty($request->docum_entregada)) {
            $filtro[] = ['grupo_familiar.docum_entregada', '<=', $request->docum_entregada];
        }
        if (!empty($request->nacionalidad_id)) {
            $filtro[] = ['grupo_familiar.nacionalidad_id', '=', $request->nacionalidad_id];
        }
        if (!empty($request->fecha_egreso_sind)) {
            $filtro[] = ['grupo_familiar.fecha_egreso_sind', '=', $request->fecha_egreso_sind];
        }
        if (!empty($request->motivo_egreso_sind_id)) {
            $filtro[] = ['grupo_familiar.motivo_egreso_sind_id', '=', $request->motivo_egreso_sind_id];
        }
        if (!empty($request->provincia_id)) {
            $filtro[] = ['grupo_familiar.provincia_id', '=', $request->provincia_id];
        }
        if (!empty($request->localidad_id)) {
            $filtro[] = ['grupo_familiar.localidad_id', '=', $request->localidad_id];
        }
        if (!empty($request->tipo_parentesco_id)) {
            $filtro[] = ['grupo_familiar.tipo_parentesco_id', '=', $request->tipo_parentesco_id];
        }
        if (!empty($request->discapacitado)) {
            $filtro[] = ['grupo_familiar.discapacitado', '=', $request->discapacitado];
        }

        try {
            if (empty($filtro)) {
                if (!$request->has('page')) {
                    throw new Exception('Es obligatorio ingresar por lo menos un dato a buscar');
                }
            }

            // DB::enableQueryLog();

            // no uso estado ficha pero no lo quite de la consulta, si hace falta sacar estado ficha
            $grupo_familiar = grupo_familiar::where($filtro)
                ->orderby('grupo_familiar.apellido_nombres')
                ->paginate(15);
            // $log = DB::getQueryLog();
            // dd($log);
            // dd($grupo_familiar);
        } catch (\Exception $e) {
            $msg =  $e->getMessage();
            return back()->withErrors(['mensaje' => $msg]);
        }

        return view('familiares.buscar_resultados', compact('grupo_familiar'));
    }

    public function guardar(familiaresRequest $request)
    {
        // $requestData = new afiliado();
        $requestData = $request->all();
        $requestData['user_last_name'] = Auth::user()->last_name;
        //  dd($requestData);
        grupo_familiar::updateorcreate(['id' => $request->id], $requestData);

        // return redirect('afiliados.ficha')->with('mensaje', );
        return back()->with(["mensaje" => 'Familiar creado con éxito!']);
        //return redirect()->route('familiares.index', $request->afiliado_id)->with(["mensaje" => 'Familiar creado con éxito!']);
    }

    public function documentos_index(int $afiliado_id, int $grupo_familiar_id)
    {
        $tipos_documentos = tipo_documento::where('tipo', 'FAM')->get();
        // $gf_documentos = gf_documento::query()
        //     ->join('tipos_documentos as td', 'td.id', 'gf_documentos.tipo_documento_id')
        //     ->select('td.descripcion', 'fecha_vencimiento', 'obs', 'tipo_documento_id', 'grupo_familiar_id', 'gf_documentos.id')
        //     ->where('gf_documentos.grupo_familiar_id', $grupo_familiar_id)
        //     ->paginate(5);
        $gf_documentos = gf_documento::where('grupo_familiar_id', $grupo_familiar_id)
            ->paginate(5);

        return view('familiares.documentos', compact('afiliado_id', 'grupo_familiar_id', 'tipos_documentos', 'gf_documentos'));
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
            //$path = $request->file('path')->store('public/familiares/documentacion');
            $path = Storage::disk('uploads')->put('familiares/documentacion',  $request->file('path'));
            // dd($path);
            $requestData['path'] = $path;
        }
        //  dd($requestData);
        gf_documento::create($requestData);

        // return redirect('afiliados.ficha')->with('mensaje', );
        return back()->with(["mensaje" => 'documentación cargada con éxito!']);
    }

    public function documentos_borrar(int $id)
    {

        $preg = gf_documento::find($id);
        if (!empty($preg->path)) {
            // Storage::delete($preg->path);
        }
        $preg->delete();

        return back()->with(["mensaje" => 'pregunta y respuesta borrada con éxito!']);
    }

    public function carnet($afiliado_id, $familiar_id)
    {
        $familiar = grupo_familiar::where("id", $familiar_id)->first();

        return view(
            'familiares.Carnet',
            compact(
                'familiar'
            )
        );
    }

    public function carnet_pdf($afiliado_id, $familiar_id)
    {
        $pdf = app('dompdf.wrapper');
        // $pdf->loadView('afiliados.carnet_pdf', compact('afiliado'));
        // return $pdf->download('carnet_' . $afiliado->nro_doc . '.pdf');
        // dd($afiliado->id);
        $familiar = DB::select('call pro_familiar_carnet(?, ?)', [$afiliado_id, $familiar_id])[0];

        $fecha = "";
        if ($familiar->discapacitado == 'S') {
            $reporte = 'carnet_disca_pdf';
        } elseif (ENV('HIJO_MAYOR_ESTUD') == $familiar->tipo_parentesco_id) {
            $reporte = 'carnet_hijo_mayor_pdf';
        } elseif (!empty(in_array($familiar->tipo_parentesco_id, explode(';', ENV('CONYUGUE'))))) {
            $reporte = 'carnet_familiar_pdf';
        } else {
            $reporte = 'carnet_hijo_pdf';
        }

        $fecha = date_add(date_create($familiar->fecha_nac), date_interval_create_from_date_string("21 year"))->format('d/m/Y');
        //dd($fecha, $familiar->fecha_nac);
        // if( $fecha->diff(now())->format('%y') > 1 ) { 
        //    $fecha = $familiar->fecha_nac; 
        // }
        return view(
            'familiares.informes.' . $reporte,
            compact('familiar', 'fecha')
        );
    }

    public function crop_foto(Request $request)
    {

        $image_parts = explode(";base64,", $request->image);
        $image_base64 = base64_decode($image_parts[1]);
        //$name =  'foto_'. md5("foto") . '.png';
        Storage::disk('fotostmp')->put($request->hi_name, $image_base64);

        $data['success'] = true;
        $data['name'] = $request->hi_name;

        return response()->json($data);
    }

    public function tomar_foto(Request $request)
    {

        $file = $request->image;
        $imagenCodificadaLimpia = str_replace("data:image/png;base64,", "", urldecode($file));
        $imagenDecodificada = base64_decode($imagenCodificadaLimpia);
        $name = $this->name_img;
        if (!empty($request->hi_name)) {
            $name = $request->hi_name;
        }

        Storage::disk('fotostmp')->put($name, $imagenDecodificada);

        $data['success'] = true;
        //$data['path'] = Storage::disk('fotostmp')->url($name);
        $data['name'] = $name;

        return response()->json($data);
    }

    public function file_input_Photo(Request $request)
    {

        $this->validate($request, [
            'photo' => 'required|image'
        ]);

        $file = $request->file('photo');
        $name = Storage::disk('fotostmp')->put('', $file);

        $data['success'] = true;
        $data['name'] = $name;

        return $data;
    }

    public function foto_guardar(Request $request)
    {

        if (storage::disk('fotostmp')->exists($request->hi_name)) {
            $familiar = grupo_familiar::where('id', $request->familiar_id)->first();
            // dump($familiar);die;
            $destino = 'foto_' . $request->familiar_id . '.png';
            $origen = '/tmp/' . $request->hi_name;
            storage::disk('fotos')->delete($destino);
            storage::disk('fotos')->move($origen, $destino);

            $familiar->path = $destino;
            $familiar->save();
            $result = 'foto guardada con éxito!';
        } else {

            return back()->withErrors(['mensaje' => 'No se ha modificado la imagen actual, debe Tomar una foto o Subir una foto para luego guardarla en el sistema']);
        }

        return redirect()->route('familiares.carnet',  [$request->afiliado_id, $request->familiar_id]);
    }

    public function download(int $id)
    {
        $path = gf_documento::find($id)->path;
        if (!file_exists($path)) {
            return back()->withErrors(['mensaje' => "El archivo que intenta descargar no se encuentra almacenado en el servidor."]);
        }
        return response()->download(public_path() . '/' . $path);
    }

    //-------------------------------------------------------------------------------------------------------------------------------------

    public function escolaridad_index(int $afiliado_id, int $grupo_familiar_id)
    {
        $tipos_material = tipo_material::get();
        $gf_escolaridad_hist = gf_escolaridad::where('grupo_familiar_id', $grupo_familiar_id)->paginate();
        // dd($gf_escolaridad);
        if (empty($gf_escolaridad)) {
            $gf_escolaridad = new gf_escolaridad;
            $gf_escolaridad->ciclo_lectivo = now()->year;
            $gf_escolaridad->mochila = 'S';
            $gf_escolaridad->kit_escolar = 'S';
            $gf_escolaridad->nivel = 'primario';
        }

        return view('familiares.escolaridad', compact('gf_escolaridad_hist', 'afiliado_id', 'grupo_familiar_id', 'gf_escolaridad'));
    }

    public function escolaridad_guardar(Request $request)
    {
        $request->validate([
            'ciclo_lectivo' => 'required',
            'mochila' => 'required',
            'kit_escolar' => 'required',
            'nivel' => 'required',
            'tipo_educacion' => 'required',
            'delantal' => ['required',
                function ($attribute, $value, $fail) use ($request) {
                    if (($request->input($attribute) == 'S')) {
                        if ($request->input('talle') == null) {
                            $fail('Si selecciona que requiere Delantal es obligatorio seleccionar el Talle a entregar.');
                        }
                    }
                }
            ],
        ]);

        try {
            $requestData = $request->all();
            if ($request->id) {
                $gf_escolaridad = gf_escolaridad::find($request->id);
            } else {
                $existe = gf_escolaridad::where("grupo_familiar_id", $request->grupo_familiar_id)
                ->where("ciclo_lectivo", $request->ciclo_lectivo)
                ->first();
                if ($existe) {
                    throw new ModelNotFoundException("Ya se encuentra cargado la entrega de Utilies para el Afiliado en este periodo, no es posible guardar los datos.");
                }
                $gf_escolaridad = new gf_escolaridad($requestData);
            }
            $gf_escolaridad->save();

            return back()->with(["mensaje" => 'Material escolar cargado con éxito!']);
        } catch (ModelNotFoundException  $e) {
            return back()->withErrors(['mensaje' => $e->getMessage() ]);
        }
    }

    public function escolaridad_borrar(int $id)
    {
        $preg = gf_escolaridad::find($id);
        $preg->delete();

        return back()->with(["mensaje" => 'Material escolar borrado con éxito!']);
    }
}
