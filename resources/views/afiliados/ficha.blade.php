@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<form id='formEmpbus' action="{{route('afiliado.find')}}" method="GET">
    <div class="row">
        <div class="col-md-4">
            <h4>Ficha de Afiliado</h4>
        </div>
        <div class="col-md-4 offset-md-4 bot-20  justify-content-end">
            <div class="input-group">
                <input type="text" data-toggle="tooltip" data-placement="top" title="Ingrese un número de dni a buscar"
                    placeholder="D.N.I." id="busdni" name="busdni" class="solonros form-control form-control-sm"
                    aria-describedby="buscar" maxlength="10">
                <input type="text" data-toggle="tooltip" data-placement="top"
                    title="Ingrese un número de afiliado sindical" placeholder="Nro Afiliado" id="busnroafil"
                    name="busnroafil" class="solonros form-control form-control-sm" aria-describedby="buscar"
                    maxlength="12">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-sm" type="submit" id="buscar"><i
                            class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id='formEmp' action="{{route('afiliado.guardar')}}" method="POST">
    @csrf
    <input type='hidden' id='id' name='id' value="{{$registro->id}}" />
    <input type='hidden' id='afiliado_empresa_id' name='afiliado_empresa_id' value="{{$afiliado_empresa->id}}" />
    <div class="bot-20">
        <div class="card border-primary">
            <div class="card-header">
                @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo afiliado'))
                <a href="{{ route('afiliado.index') }}" class="btn btn-success btn-sm" title="Agregar"> <i
                        class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo</a>
                @endif
                Datos personales del titular
                <span class='fa-trash-alt float-right'>(*) todo lo marcado con asterisco es un dato obligatorio.</span>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Estado </label><span class='s-red'>*</span>
                                <select name="afil_estado_ficha_id" id="afil_estado_ficha_id"
                                    class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($estados as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($registro->afil_estado_ficha_id) ? old('afil_estado_ficha_id') : $registro->afil_estado_ficha_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Doc. pendiente</label>
                                <input type="date" id="docum_pendiente" name="docum_pendiente"
                                    class="form-control form-control-sm"
                                    value="{{ old('docum_pendiente', $registro->docum_pendientey) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Doc. entregada</label>
                                <input type="date" id="docum_entregada" name="docum_entregada"
                                    class="form-control form-control-sm"
                                    value="{{   old('docum_entrega', $registro->docum_entregaday) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Nro Afiliado</label><span class='s-red'>*</span>
                            <div class="input-group" data-toggle="tooltip" data-placement="top"
                                title="Presione el botón para obtener un número de afiliado, trae un dato solo si la casilla de texto esta en blanco.">
                                <input type="text" id="nro_afil_sindical" name="nro_afil_sindical"
                                    data-tipo='NRO_AFIL_TIT'
                                    class="valorsiguiente solonros form-control form-control-sm"
                                    aria-describedby="signroafil"
                                    value="{{  old('nro_afil_sindical', $registro->nro_afil_sindical) }}"
                                    maxlength="12">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-sm" id="obtsiguiente"><i
                                            class="fas fa-sort-numeric-up"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">CUIL</label><span class='s-red'>*</span>
                                <input type="text" id="" name="cuil" class="solonros form-control form-control-sm"
                                    value="{{  old('cuil', $registro->cuil) }}" maxlength="13" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Apellido y nombre</label><span class='s-red'>*</span>
                                <input type="text" id="apellido_nombres" name="apellido_nombres"
                                    class="aMayusculas form-control form-control-sm"
                                    value="{{  old('apellido_nombres', $registro->apellido_nombres) }}"
                                    maxlength="150" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Tipo Doc</label><span class='s-red'>*</span>
                                <select name="tipo_documento_id" id="tipo_documento_id"
                                    class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_documentos as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($registro->tipo_documento_id) ? old('tipo_documento_id') : $registro->tipo_documento_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nro docum.</label><span class='s-red'>*</span>
                                <input type="text" id="" name="nro_doc" class="solonros form-control form-control-sm"
                                    value="{{ old('nro_doc', $registro->nro_doc) }}" maxlength="12" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. Nac.</label><span class='s-red'>*</span>
                                <input type="date" id="fecha_nac" name="fecha_nac" class="form-control form-control-sm"
                                    value="{{ old('fecha_nac', $registro->fecha_nacy) }}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Edad</label>
                                <input type="text" id="edad" name="edad" class="form-control form-control-sm"
                                    readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Nacionalidad</label>
                                <select name="nacionalidad_id" id="nacionalidad_id" class="form-control form-control-sm"
                                    style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($nacionalidades as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($registro->nacionalidad_id) ? old('nacionalidades') : $registro->nacionalidad_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Estado civil</label><span class='s-red'>*</span>
                                <select name="estado_civil_id" id="estado_civil_id" class="form-control form-control-sm"
                                    style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($estado_civil as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($registro->estado_civil_id) ? old('estado_civil') : $registro->estado_civil_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Sexo</label><span class='s-red'>*</span>
                                <select name="sexo" id="sexo" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    <option value="F"
                                        {{(empty($registro->sexo) ? old('sexo') : $registro->sexo)  == "F" ? 'selected' : ''}}>
                                        Femenino</option>
                                    <option value="M"
                                        {{(empty($registro->sexo) ? old('sexo') : $registro->sexo)  == "M" ? 'selected' : ''}}>
                                        Masculino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefonos</label>
                                <input type="text" id="" name="telefono1" class="form-control form-control-sm"
                                    value="{{ old('telefono1', $registro->telefono1) }}" maxlength="60" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="" name="email" class="form-control form-control-sm"
                                    value="{{ old('email', $registro->email) }}" maxlength="60" />
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Calle</label><span class='s-red'>*</span>
                                <input type="text" id="" name="calle" class="aMayusculas form-control form-control-sm"
                                    value="{{ old('calle', $registro->calle) }}" maxlength="100" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Nro</label><span class='s-red'>*</span>
                                <input type="text" id="" name="calle_nro" class="form-control form-control-sm"
                                    value="{{ old('calle_nro', $registro->calle_nro) }}" maxlength="10" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Piso</label>
                                <input type="text" id="" name="calle_piso" class="form-control form-control-sm"
                                    value="{{ old('calle_piso', $registro->calle_piso) }}" maxlength="10" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Provincia</label>
                                <select name="provincia_id" id="provincia_id" data-localidad='localidad_id'
                                    class="provincia form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($provincias as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($registro->provincia_id) ? old('provincia_id') : $registro->provincia_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" data-placement="top" title="Debe haber seleccionado una Provincia para que se carguen las localidades.">
                                <label for="">Localidad y C.P.</label>
                                <select name="localidad_id" id="localidad_id" class="busqueda form-control"
                                    style="width: 100%">
                                    @if($localidades != null){
                                    <option value="{{$localidades->id}}">
                                        {{$localidades->nombre . ' - ' . $localidades->cod_postal }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <input type="text" id="" name="calle_obs" class="form-control form-control-sm"
                                    value="{{ old('calle_obs', $registro->calle_obs) }}" maxlength="150" />
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bot-20">
        <div class="card border-primary">
            <div class="card-header">
                Datos laborales (ACTUAL)
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Seccional</label><span class='s-red'>*</span>
                                <select name="seccional_id" id="seccional_id" class="busqueda form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($seccionales as $dato)
                                    <option value="{{$dato->id}}"
                                        {{ (empty($afiliado_empresa->seccional_id) ? old('seccional_id') : $afiliado_empresa->seccional_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Categoria</label>
                                <select name="categoria_id" id="categoria_id" class="busqueda form-control form-control-sm"
                                    style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($categorias as $dato)
                                    <option value="{{$dato->id}}"
                                        {{    (empty($afiliado_empresa->categoria_id) ? old('categoria_id') : $afiliado_empresa->categoria_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Especialidad</label>
                                <select name="especialidad_id" id="especialidad_id" class="form-control form-control-sm"
                                    style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($especialidades as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($afiliado_empresa->especialidad_id) ? old('especialidad_id') : $afiliado_empresa->especialidad_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. afiliación</label><span class='s-red'>*</span>
                                <input type="date" id="fecha_ingreso" name="fecha_ingreso"
                                    class="form-control form-control-sm"
                                    value="{{  old('fecha_ingreso', $afiliado_empresa->fecha_ingresoy) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_egreso" name="fecha_egreso"
                                    class="colorear form-control form-control-sm"
                                    value="{{ old('fecha_egreso', $afiliado_empresa->fecha_egresoy) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Motivo baja Sindical</label>
                                <select name="motivo_egreso_id" id="motivo_egreso_id"
                                    class="colorear form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($motivos_egresos_sind as $dato)
                                    <option value="{{$dato->id}}" {{ old('motivos_egresos_sind', $afiliado_empresa->motivo_egreso_id)  == $dato->id ? 'selected' : '' }}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Empresa</label><span class='s-red'>*</span>
                                <select name="empresa_id" id="empresa_id" class="busqueda form-control form-control-sm"
                                    style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($empresas as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($afiliado_empresa->empresa_id) ? old('empresa_id') : $afiliado_empresa->empresa_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->razon_social}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. ingreso</label><span class='s-red'>*</span>
                                <input type="date" id="fecha_ing_empr" name="fecha_ing_empr"
                                    class="form-control form-control-sm"
                                    value="{{ old('fecha_ing_empr', $afiliado_empresa->fecha_ing_empry) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_egr_empr" name="fecha_egr_empr"
                                    class="form-control form-control-sm"
                                    value="{{ old('fecha_egr_empr', $afiliado_empresa->fecha_egr_empry) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Delegado desde</label>
                                <input type="date" id="delegado_desde" name="delegado_desde"
                                    class="form-control form-control-sm"
                                    value="{{ old('delegado_desde', $afiliado_empresa->delegado_desdey) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Delegado hasta</label>
                                <input type="date" id="delegado_hasta" name="delegado_hasta"
                                    class="form-control form-control-sm"
                                    value="{{ old('delegado_hasta', $afiliado_empresa->delegado_hastay) }}">
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bot-20">
        <div class="card border-primary">
            <div class="card-header">
                Datos de Obra social
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <div id="tooltip_container"></div>
                                <label for="">Obra social</label>
                                <select name="obra_social_id" id="obra_social_id" class="form-control form-control-sm"
                                    style="width: 100%">
                                    <option value="" data-toggle="tooltip" data-container="#tooltip_container"
                                        title="Finding your IMEI number">--Seleccione--</option>
                                    @foreach($obras_sociales as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($registro->obra_social_id) ? old('obra_social_id') : $registro->obra_social_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. ingreso</label>
                                <input type="date" id="fecha_ingreso_os" name="fecha_ingreso_os"
                                    class="form-control form-control-sm"
                                    value="{{ old('fecha_ingreso_os', $registro->fecha_ingreso_osy) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. egreso O.S.</label>
                                <input type="date" id="fecha_egreso_os" name="fecha_egreso_os"
                                    class="colorear form-control form-control-sm"
                                    value="{{ old('fecha_egreso_os', $registro->fecha_egreso_osy) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Motivo de baja O.S.</label>
                                <select name="motivo_egreso_os_id" id="motivo_egreso_os_id"
                                    class="colorear form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($motivos_egresos_os as $dato)
                                    <option value="{{$dato->id}}"
                                        {{(empty($registro->motivo_egreso_os_id) ? old('motivo_egreso_os_id') : $registro->motivo_egreso_os_id)  == $dato->id ? 'selected' : ''}}>
                                        {{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Discapacitado</label>
                            <div class="container">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="S" name="discapacitado"
                                            {{(empty($registro->discapacitado) ? old('discapacitado') : $registro->discapacitado) =='S' ? 'checked' : ''}}>SI</input>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="N" name="discapacitado"
                                            {{(empty($registro->discapacitado) ? old('discapacitado')  : $registro->discapacitado) =='N' ? 'checked' : ''}}>NO</input>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. jubilacón</label>
                                <input type="date" id="fecha_jubilacion" name="fecha_jubilacion"
                                    class="form-control form-control-sm"
                                    value="{{ old('fecha_jubilacion', $registro->fecha_jubilaciony) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nro benef. Anses</label>
                                <input type="text" id="" name="nro_ben_anses" class="form-control form-control-sm"
                                    value="{{ old('nro_ben_anses', $registro->nro_ben_anses) }}" maxlength="10" />
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bot-20">
        <div class="card border-primary">
            <div class="card-header">
                Datos Generales
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones generales</label>
                                <input type="text" id="" name="obs_gral" class="form-control form-control-sm"
                                    value="{{ old('obs_gral', $registro->obs_gral) }}" maxlength="500" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="e" class="form-control form-control-sm text-center bg-gradient-light ">Usuario :
                                {{ $registro->user_last_name }} / Ult. modif. : {{ $registro->updated_at }} </label>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class='row'>
                        <div class="col-md-8">
                            @if(isset($registro->id))
                            <div class='float-right'>
                                <a href=" {{ route('afiliado.empresas', $registro->id) }} " id="btnempresas"
                                    class="btn btn-primary">Empresas <span
                                        class="badge badge-light">{{$cantidades['empresas']}}</span></a>
                                <a href=" {{ route('afiliado.documentos', $registro->id) }} " id="btnfoto"
                                    class="btn btn-primary">Documentación <span
                                        class="badge badge-light">{{$cantidades['documentos']}}</span></a>
                                <a href=" {{ route('afiliado.carnet', $registro->id) }} " id="btncarnet"
                                    class="btn btn-primary">Carnet <span
                                        class="badge badge-light">{{$cantidades['foto']}}</span></a>
                                <a href=" {{ route('familiares.index', $registro->id) }} " id="btgrupofam"
                                    class="btn btn-primary">Grupo familiar <span
                                        class="badge badge-light">{{$cantidades['grupo_fam']}}</span></a>
                                <a href=" {{ route('afiliado.preguntas', $registro->id) }} " id="btnpreguntas"
                                    class="btn btn-primary">Preguntas <span
                                        class="badge badge-light">{{$cantidades['preguntas']}}</span></a>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class='float-right'>
                                <a href="{{ route('familiares.buscar.index', isset($registro->id) ? $registro->id : 0) }}"
                                    id="btnbuscarfam" class="btn btn-info"><i class="fas fa-search"></i> Familiar</a>
                                <a href="{{ route('afiliado.buscar.index', isset($registro->id) ? $registro->id : 0) }}"
                                    id="btnbuscartit" class="btn btn-info"><i class="fas fa-search"></i> Titular</a>
                                @if(Auth::user()->hasrole('administrador') or Auth::user()->hasPermissionTo('nuevo afiliado'))
                                        <button type="submit" id="btnAgr" class="btn btn-info">Guardar datos</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</form>


<script src="{{ asset('js/scripts.js') }}"></script>
<script>
$(function() {

    var html_select = '';
    var combo = $('#motivo_egreso_id');

    $.get('/api/afiliado/motivos_egresos/', function(data) {
        for (var i = 0; i < data.length; ++i) {
            combo.append(new Option(data[i].descripcion, data[i].id));
            //    console.log(combo.children().last());
            combo.children().last().attr({
                "data-toggle": "tooltip",
                "title": data[i].tooltips,
                "data-placement": "top"
            });
        }

    })

    //$('.select2').select2({});


});
</script>

@endsection