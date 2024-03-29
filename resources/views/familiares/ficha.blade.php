@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<div class="row">
    <div class="col-md-12 text-center alert alert-dark">
        {{$titular}}
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Apellido y nombre</th>
                        <th>DNI</th>
                        <th>Parentesco</th>
                        <th>Fecha nac.</th>
                        <th>Fecha alta</th>
                        <th>Fecha baja</th>
                        <th style="width:8%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupo_familiar as $item)
                    <tr @if(!empty($item->fecha_egreso_sind)) class="table-danger" @endif>
                        <td>{{ $loop->iteration }}</td>
                        <td> @if ($item->entregado)
                            <i class="fa fa-book" aria-hidden="true"></i>
                            @endif </td>
                        <td>{{ $item->apellido_nombres }}</td>
                        <td>{{ $item->nro_doc }}</td>
                        <td>{{$item->tipos_parentescos->descripcion }} </td>
                        <td>{{ $item->fecha_nac }}</td>
                        <td>{{ $item->fecha_ingreso_sind }}</td>
                        <td>{{ $item->fecha_egreso_sind }}</td>
                        <td>
                            <div class="float-right">
                                <a href="{{ route('familiares.index', [$afiliado_id, $item->id]) }}" class="btn btn-success btn-sm" title="Modificar y consultar datos completos del familiar y sus datos asociados como ser documentos."><i class="fa fa-users" aria-hidden="true"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- @if(!empty($afil_preguntas)) -->
            <div class="pagination-wrapper"> {!! $grupo_familiar->appends(['search' => Request::get('search')])->render() !!} </div>
            <!-- @endif -->
        </div>
    </div>
</div>

<form id='formEmp' action="{{route('familiares.guardar')}}" method="POST">
    @csrf
    <input type='hidden' id='id' name='id' value="{{$registro->id}}" />
    <input type='hidden' id='afiliado_id' name='afiliado_id' value="{{$afiliado_id}}" />
    <div class="bot-20">
        <div class="card ">
            <div class="card-header">
                <a href="{{ route('afiliado.find', $afiliado_id) }}" title="Volver" class="btn btn-warning btn-sm"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
                @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo afiliado'))
                <a href="{{ route('familiares.index', $afiliado_id) }}" class="btn btn-success btn-sm" title="Agregar nuevo Role"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo</a>
                @endif
                Datos completos del familiar
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Apellido y nombre</label><span class='s-red'>*</span>
                                <input type="text" id="apellido_nombres" name="apellido_nombres" class="aMayusculas form-control form-control-sm" value="{{ old('apellido_nombres', $registro->apellido_nombres) }}" maxlength="150" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Doc. pendiente</label>
                                <input type="date" id="docum_pendiente" name="docum_pendiente" class="form-control form-control-sm" value="{{ old('docum_pendiente', $registro->docum_pendientey) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Doc. entregada</label>
                                <input type="date" id="docum_entregada" name="docum_entregada" class="form-control form-control-sm" value="{{ old('docum_entregada', $registro->docum_entregaday) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Nro Afiliado</label>
                                <input type="text" id="" name="nro_grupo_fam" class="form-control form-control-sm" readonly value="{{  old('nro_grupo_fam', $registro->nro_grupo_fam) }}" maxlength="13" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">CUIL</label>
                                <input type="text" id="" name="cuil" class="solonros form-control form-control-sm" value="{{  old('cuil', $registro->cuil) }}" maxlength="13" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Tipo Doc</label><span class='s-red'>*</span>
                                <select name="tipo_documento_id" id="tipo_documento_id" class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_documentos as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->tipo_documento_id) ? old('tipo_documento_id') : $registro->tipo_documento_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nro docum.</label><span class='s-red'>*</span>
                                <input type="text" id="" name="nro_doc" class="solonros form-control form-control-sm" value="{{ old('nro_doc', $registro->nro_doc) }}" maxlength="12" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. Nac.</label><span class='s-red'>*</span>
                                <input type="date" id="fecha_nac" name="fecha_nac" class="form-control form-control-sm" value="{{ old('fecha_nac', $registro->fecha_nacy) }}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Edad</label>
                                <input type="text" id="edad" name="edad" class="form-control form-control-sm" readonly />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Parentesco</label><span class='s-red'>*</span>
                                <select name="tipo_parentesco_id" id="tipo_parentesco_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_parentescos as $dato)
                                    <option value="{{$dato->id}}" {{ old('tipo_parentesco_id', $registro->tipo_parentesco_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                                    @if($localidades != null)
                                        <option value="{{$localidades->id}}">{{$localidades->nombre . ' - ' . $localidades->cod_postal }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Nacionalidad</label>
                                <select name="nacionalidad_id" id="nacionalidad_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($nacionalidades as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->nacionalidad_id) ? old('nacionalidad_id') : $registro->nacionalidad_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Estado civil</label>
                                <select name="estado_civil_id" id="estado_civil_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($estado_civil as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->estado_civil_id) ? old('estado_civil_id') : $registro->estado_civil_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Sexo</label><span class='s-red'>*</span>
                                <select name="sexo" id="sexo" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    <option value="F" {{(empty($registro->sexo) ? old('sexo') : $registro->sexo)  == "F" ? 'selected' : ''}}>Femenino</option>
                                    <option value="M" {{(empty($registro->sexo) ? old('sexo') : $registro->sexo)  == "M" ? 'selected' : ''}}>Masculino</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>Discapacitado</label>
                            <div class="container">
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="S" name="discapacitado" {{(empty($registro->discapacitado) ? old('discapacitado') : $registro->discapacitado) =='S' ? 'checked' : ''}}>SI</input>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" value="N" name="discapacitado" {{(empty($registro->discapacitado) ? old('discapacitado')  : $registro->discapacitado) =='N' ? 'checked' : ''}}>NO</input>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Vto. certifidado</label>
                                <input type="date" id="fecha_venc_disca" name="fecha_venc_disca" class="form-control form-control-sm" value="{{ old('fecha_venc_disca', $registro->fecha_venc_discay) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Telefono</label>
                                <input type="text" id="" name="telefonos" class="form-control form-control-sm" value="{{ old('telefonos', $registro->telefonos) }}" maxlength="60" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones generales</label>
                                <input type="text" id="" name="obs" class="form-control form-control-sm" value="{{ old('obs', $registro->obs) }}" maxlength="500" />
                            </div>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. afiliación</label>
                                <input type="date" id="fecha_ingreso_sind" name="fecha_ingreso_sind" class="form-control form-control-sm" value="{{ old('fecha_ingreso_sind', $registro->fecha_ingreso_sindy) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_egreso_sind" name="fecha_egreso_sind" class="colorear form-control form-control-sm" value="{{ old('fecha_egreso_sind', $registro->fecha_egreso_sindy) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Motivo baja</label>
                                <select name="motivo_egreso_sind_id" id="motivo_egreso_sind_id" class="colorear form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($motivos_egresos_sind as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->motivo_egreso_sind_id) ? old('motivo_egreso_sind_id') : $registro->motivo_egreso_sind_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="e" class="form-control form-control-sm text-center bg-gradient-light ">Usuario : {{ $registro->user_last_name }} / Ult. modif. : {{ $registro->updated_at }} </label>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class='row'>
                        <div class="col-md-8">
                            @if(isset($registro->id))
                            <div class='float-right'>
                                {{-- <a href=" {{ route('familiares.escolaridad', [$afiliado_id, $registro->id]) }} " id="btnescuela" class="btn btn-primary">Escolaridad <span class="badge badge-light">{{$cantidades['escolaridad']}}</span></a> --}}
                                <a href=" {{ route('familiares.escolaridad', [$afiliado_id, $registro->id]) }} " id="btnescolaridad" class="btn btn-primary">Escolaridad </a>
                                <a href=" {{ route('familiares.documentos', [$afiliado_id, $registro->id]) }} " id="btndocum" class="btn btn-primary">Documentación <span class="badge badge-light">{{$cantidades['documentos']}}</span></a>
                                <a href=" {{ route('familiares.carnet', [$afiliado_id, $registro->id]) }} " id="btncarnet" class="btn btn-primary">Carnet <span class="badge badge-light">{{$cantidades['foto']}}</span></a>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo familiar'))
                            <button type="submit" id="btnguardarfam" class="btn btn-info float-right">Guardar datos</button>
                            @endif
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</form>


<script src="{{ asset('js/scripts.js') }}"></script>

@endsection