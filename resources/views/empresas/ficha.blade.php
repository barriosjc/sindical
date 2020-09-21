@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<form id='formEmpbus' action="{{route('empresa.find')}}" method="GET">
    <div class="row bot-20  justify-content-end">
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" data-toggle="tooltip" data-placement="top" title="Ingrese un número de dni a buscar" placeholder="CUIT" id="buscuit" name="buscuit" class="solonros form-control form-control-sm" aria-describedby="buscar" maxlength="13">
                <input type="text" data-toggle="tooltip" data-placement="top" title="Ingrese un número de código empresa" placeholder="Cód. de empresa" id="buscodempr" name="buscodempr" class="solonros form-control form-control-sm" aria-describedby="buscar" maxlength="12">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-sm" type="submit" id="buscar"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id='formEmp' action="{{route('empresa.guardar')}}" method="POST">
    @csrf
    <input type='hidden' id='id' name='id' value="{{$registro->id}}" />
    <div class="bot-20">
        <div class="card ">
            <div class="card-header">
                @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nueva empresa'))                
                <a href="{{ route('empresa.index') }}" class="btn btn-success btn-sm" title="Agregar"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo</a>
                @endif
                Datos de empresa
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Seccional</label>
                                <select name="seccional_id" id="seccional_id" class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($seccionales as $dato)
                                    <option value="{{$dato->id}}" {{ (empty($registro->seccional_id) ? old('seccional_id') : $registro->seccional_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Código de empresa</label>
                            <div class="input-group" data-toggle="tooltip" data-placement="top" title="Presione el botón para obtener un número de empresa, trae un dato solo si la casilla de texto esta en blanco.">
                                <input type="text" id="cod_empresa" name="cod_empresa" data-tipo="NRO_EMPRESA" class="valorsiguiente solonros form-control form-control-sm" aria-describedby="signroafil" value="{{  old('cod_empresa', $registro->cod_empresa) }}" maxlength="12">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-sm" id="obtsiguiente"><i class="fas fa-sort-numeric-up"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="">Razón social</label>
                                <input type="text" id="razon_social" name="razon_social" class="aMayusculas form-control form-control-sm" value="{{  old('razon_social', $registro->razon_social) }}" maxlength="150" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Rama</label>
                                <select name="tipo_rama_empr_id" id="tipo_rama_empr_id" class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_rama_empr as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->tipo_rama_empr_id) ? old('tipo_rama_empr_id') : $registro->tipo_rama_empr_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Actividad de la empresa</label>
                                <select name="tipo_actividad_empr_id" id="tipo_actividad_empr_id" class="busqueda form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_actividad_empr as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->tipo_actividad_empr_id) ? old('tipo_actividad_empr') : $registro->tipo_actividad_empr_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">CUIT</label>
                                <input type="text" id="" name="cuit" class="solonros form-control form-control-sm" value="{{  old('cuit', $registro->cuit) }}" maxlength="13" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. Sindical</label>
                                <input type="date" id="fecha_inicio_actividad" name="fecha_inicio_actividad" class="form-control form-control-sm" value="{{  old('fecha_inicio_actividad', $registro->fecha_inicio_actividady) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. Alta</label>
                                <input type="date" id="fecha_alta" name="fecha_alta" class="form-control form-control-sm" value="{{  old('fecha_alta', $registro->fecha_altay) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_baja" name="fecha_baja" class="colorear form-control form-control-sm" value="{{ old('fecha_baja', $registro->fecha_bajay) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Motivo baja Sindical</label>
                                <select name="tipo_baja_empr_id" id="tipo_baja_empr_id" class="colorear form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_baja_empr as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->tipo_baja_empr_id) ? old('tipo_baja_empr_id') : $registro->tipo_baja_empr_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. Ult. Inspec.</label>
                                <input type="date" id="fecha_ult_inspeccion" name="fecha_ult_inspeccion" class="form-control form-control-sm" value="{{ old('fecha_ult_inspeccion', $registro->fecha_ult_inspecciony) }}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Novedades</label>
                                <input type="text" id="novedades" name="novedades" class="form-control form-control-sm" value="{{  old('novedades', $registro->novedades) }}" maxlength="500" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Email 1</label>
                                <input type="email" id="" name="email" class="form-control form-control-sm" value="{{ old('email', $registro->email) }}" maxlength="60" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email 2</label>
                                <input type="email" id="" name="email2" class="form-control form-control-sm" value="{{ old('email2', $registro->email2) }}" maxlength="60" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Ing. brutos</label>
                                <input type="text" id="ing_brutos" name="ing_brutos" class="form-control form-control-sm" value="{{  old('ing_brutos', $registro->ing_brutos) }}" maxlength="20" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Estado</label>
                                <select name="empresa_estado_id" id="empresa_estado_id" class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($empresas_estados as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->empresa_estado_id) ? old('empresas_estados') : $registro->empresa_estado_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefonos</label>
                                <input type="text" id="" name="telefono1" class="form-control form-control-sm" value="{{ old('telefono1', $registro->telefono1) }}" maxlength="60" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefonos 2</label>
                                <input type="text" id="" name="telefono2" class="form-control form-control-sm" value="{{ old('telefono2', $registro->telefono2) }}" maxlength="60" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Cant. Emp.</label>
                                <input type="text" id="" name="cant_empleados" class="solonros form-control form-control-sm" value="{{ old('cant_empleados', $registro->cant_empleados) }}" maxlength="5" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Cant. empadronados</label>
                                <input type="text" id="cant_empadronados" name="cant_empadronados" class="form-control form-control-sm" value="{{$cant_empadronados}}" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Tiene delegado/s</label>
                            <div class="container">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="S" name="tiene_delegado" {{(empty($registro->tiene_delegado) ? old('tiene_delegado') : $registro->tiene_delegado) =='S' ? 'checked' : ''}}>SI</input>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="N" name="tiene_delegado" {{(empty($registro->tiene_delegado) ? old('tiene_delegado')  : $registro->tiene_delegado) =='N' ? 'checked' : ''}}>NO</input>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="bot-20">
        <div class="card ">
            <div class="card-header">
                Direccion de producción
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Calle</label>
                                <input type="text" id="" name="calle" class="aMayusculas form-control form-control-sm" value="{{ old('calle', $registro->calle) }}" maxlength="100" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Nro</label>
                                <input type="text" id="" name="calle_nro" class="form-control form-control-sm" value="{{ old('calle_nro', $registro->calle_nro) }}" maxlength="10" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Piso</label>
                                <input type="text" id="" name="calle_piso" class="form-control form-control-sm" value="{{ old('calle_piso', $registro->calle_piso) }}" maxlength="10" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Provincia</label>
                                <select name="provincia_id" id="provincia_id" data-localidad='localidad_id' class="provincia form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($provincias as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->provincia_id) ? old('provincia_id') : $registro->provincia_id)  == $dato->id ? 'selected' : ''}}>{{$dato->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Localidad y C.P.</label>
                                <select name="localidad_id" id="localidad_id" class="busqueda form-control" style="width: 100%">
                                    @if($localidades != null){
                                    <option value="{{$localidades->id}}">{{$localidades->nombre . ' - ' . $localidades->cod_postal }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <input type="text" id="" name="calle_obs" class="form-control form-control-sm" value="{{ old('calle_obs', $registro->calle_obs) }}" maxlength="150" />
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="bot-20">
        <div class="card ">
            <div class="card-header">
                Direccion administrativa
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Calle</label>
                                <input type="text" id="" name="calle_adm" class="aMayusculas form-control form-control-sm" value="{{ old('calle_adm', $registro->calle_adm) }}" maxlength="100" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Nro</label>
                                <input type="text" id="" name="calle_nro_adm" class="form-control form-control-sm" value="{{ old('calle_nro_adm', $registro->calle_nro_adm) }}" maxlength="10" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Piso</label>
                                <input type="text" id="" name="calle_piso_adm" class="form-control form-control-sm" value="{{ old('calle_piso_adm', $registro->calle_piso_adm) }}" maxlength="10" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Provincia</label>
                                <select name="provincia_adm_id" id="provincia_adm_id" data-localidad='localidad_adm_id' class="provincia form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($provincias as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->provincia_adm_id) ? old('provincia_adm_id') : $registro->provincia_adm_id)  == $dato->id ? 'selected' : ''}}>{{$dato->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Localidad y C.P.</label>
                                <select name="localidad_adm_id" id="localidad_adm_id" class="busqueda form-control" style="width: 100%">
                                    @if($localidades_adm != null){
                                    <option value="{{$localidades_adm->id}}">{{$localidades_adm->nombre . ' - ' . $localidades->cod_postal }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <input type="text" id="" name="calle_obs_adm" class="form-control form-control-sm" value="{{ old('calle_obs_adm', $registro->calle_obs_adm) }}" maxlength="150" />
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="bot-20">
        <div class="card">
            <div class="card-header">
                Datos Generales
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones generales</label>
                                <input type="text" id="obs" name="obs" class="form-control form-control-sm" value="{{ old('obs', $registro->obs) }}" maxlength="500" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="e" class="form-control form-control-sm text-center bg-gradient-light ">Usuario : {{ $registro->user_last_name }} / Ult. modif. : {{ $registro->updated_at }} </label>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class='row'>
                        <div class="col-md-8 float-right">
                            @if(isset($registro->id))
                            <div class='float-right'>
                                <a href=" {{ route('empresa.documentos', $registro->id) }} " id="btnfoto" class="btn btn-primary">Documentación <span class="badge badge-light">{{$cantidades['documentos']}}</span></a>
                                <a href=" {{ route('afiliado.buscar', $registro->id) }} " id="btgrupofam" class="btn btn-primary">Afiliados <span class="badge badge-light">{{$cantidades['afiliados']}}</span></a>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-4 ">
                            <div class='float-right'>
                                <a href="{{ route('empresa.buscar.index', isset($registro->id) ? $registro->id : 0) }}" id="btnbuscartit" class="btn btn-info"><i class="fas fa-search"></i> Buscar</a>
                                @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nueva empresa'))
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

@endsection