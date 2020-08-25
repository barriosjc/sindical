<?php

namespace App\Http\Controllers\gestion;

use App\Http\Controllers\Controller;
use App\Http\Requests\familiaresRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

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
use App\models\tipo_parentesco;
use Illuminate\Support\Facades\DB;

use Exception;

class FamiliaresController extends Controller
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
    public function index(int $afiliado_id = null, int $id = null)
    {
        if (empty($id)) {
            $registro = new grupo_familiar;
        } else {
            $registro = grupo_familiar::where('id', $id)->first();
                }

        $grupo_familiar = grupo_familiar::where('afiliado_id', $afiliado_id)->with('tipos_parentescos')->get();

        $motivos_egresos_sind = motivo_egreso_sind::get();
        $tipos_documentos = tipo_documento::where('tipo', 'AFI')->get();
        $nacionalidades = tipos_nacionalidad::get();
        $estado_civil = estados_civil::get();
        $provincias = provincia::get();
        $empresas = empresa::get();
        $localidades = null;
        $tipos_parentescos = tipo_parentesco::get();
        $titular = afiliado::find($afiliado_id);
        $registro->nro_grupo_fam = $titular->nro_afil_sindical . '/00';
        $titular = 'Titular: ' . $titular->apellido_nombres . ' / DNI: ' . $titular->nro_doc;

        $cant = afil_documento::where('afiliado_id', $registro->id)->where('tipo_documento_id', 11)->count();
        $cantidades = ['foto' => $cant];
        $cant = afil_documento::where('afiliado_id', $registro->id)->where('tipo_documento_id', '!=', 11)->count();
        $cantidades['documentos'] = $cant;
        // dd($afil_preguntas->pluck('descripcion')->first());
        // $localidades = new localidad;

        return view('familiares.ficha', compact(
            'grupo_familiar',
            'nro_grupo_fam',
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

    public function guardar(familiaresRequest $request)
    {
        // $requestData = new afiliado();
        $requestData = $request->all();
        $requestData['user_last_name'] = Auth::user()->last_name;
        //  dd($requestData);
        grupo_familiar::updateorcreate(['id' => $request->id], $requestData);

        // return redirect('afiliados.ficha')->with('mensaje', );
        //return back()->with(["mensaje" => 'Familiar creado con éxito!']);
        return redirect()->route('familiares.index', $request->afiliado_id)->with(["mensaje" => 'Familiar creado con éxito!']);
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

        return view('familiares.documentos', compact('afiliado_id', 'tipos_documentos', 'afil_documentos'));
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
            $path = $request->file('path')->store('public/familiares/documentacion');
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
        if (!empty($preg->path)) {
            // Storage::delete($preg->path);
        }
        $preg->delete();

        return back()->with(["mensaje" => 'pregunta y respuesta borrada con éxito!']);
    }
}
