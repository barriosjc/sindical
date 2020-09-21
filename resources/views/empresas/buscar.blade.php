@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        @if($empresa_id == 0)
        <a href="{{ route('empresa.index') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        @else
        <a href="{{ url('/empresas/find/' . $empresa_id) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        @endif
        Datos a buscar de empresas
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <form id='formEmp' action="{{route('empresa.buscar')}}" method="get">

                <input type='hidden' name='empresa_id' value="{{ $empresa_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Seccional</label>
                            <select name="seccional_id" id="seccional_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($seccionales as $dato)
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Razón social</label>
                            <input type="text" id="razon_social" name="razon_social" class="aMayusculas form-control form-control-sm" maxlength="150" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Estado</label>
                            <select name="empresa_estado_id" id="empresa_estado_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($empresas_estados as $dato)
                                <option value="{{$dato->id}}" {{(empty($registro->empresa_estado_id) ? old('empresas_estados') : $registro->empresa_estado_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Rama</label>
                            <select name="tipo_rama_empr_id" id="tipo_rama_empr_id" class="form-control form-control-sm" style="width: 100%">
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
                            <select name="tipo_actividad_empr_id" id="tipo_actividad_empr_id" class="busqueda form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($tipos_actividad_empr as $dato)
                                <option value="{{$dato->id}}" {{(empty($registro->tipo_actividad_empr_id) ? old('tipo_actividad_empr') : $registro->tipo_actividad_empr_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fec. Sindical</label>
                            <input type="date" id="fecha_inicio_actividad" name="fecha_inicio_actividad" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fec. Alta</label>
                            <input type="date" id="fecha_alta" name="fecha_alta" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Fec. baja</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id='fecha_baja_ck' name='fecha_baja_ck' data-toggle="tooltip" data-placement="top" title="Si tilda se buscará todos los datos que no tengan fecha cargada">
                                </div>
                            </div>
                            <input type="date" id="fecha_baja" name="fecha_baja" class="form-control form-control-sm" value="" data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
                        </div>
                    </div>                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Motivo baja Sindical</label>
                            <select name="tipo_baja_empr_id" id="tipo_baja_empr_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($tipos_baja_empr as $dato)
                                <option value="{{$dato->id}}" {{(empty($registro->tipo_baja_empr_id) ? old('tipo_baja_empr_id') : $registro->tipo_baja_empr_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Fec. Ult. Inspec.</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" id='fecha_ult_inspeccion_ck' name='fecha_ult_inspeccion_ck' data-toggle="tooltip" data-placement="top" title="Si tilda se buscará todos los datos que no tengan fecha cargada">
                                </div>
                            </div>
                            <input type="date" id="fecha_ult_inspeccion" name="fecha_ult_inspeccion" class="form-control form-control-sm" value="" data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
                        </div>
                    </div>                       
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Novedades</label>
                            <input type="text" id="novedades" name="novedades" class="form-control form-control-sm" maxlength="500" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Tiene delegado/s</label>
                        <div class="container">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="S" name="tiene_delegado">SI</input>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="N" name="tiene_delegado">NO</input>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Telefonos</label>
                            <input type="text" id="" name="telefono1" class="form-control form-control-sm" maxlength="60" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Domicilio de producción</label>
                            <input type="text" id="" name="calle"  data-toggle="tooltip" data-placement="top" title="Solo busca por el nombre de la calle sin tener en cuenta nro y piso" class="aMayusculas form-control form-control-sm" maxlength="100" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Prov. producción</label>
                            <select name="provincia_id" id="provincia_adm_id" data-localidad='localidad_id' class="provincia form-control form-control-sm" style="width: 100%">
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
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Prov. admin.</label>
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
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Observaciones generales</label>
                            <input type="text" id="obs" name="obs" class="form-control form-control-sm" maxlength="500" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" id="btnAgr" class="btn btn-info float-right">Buscar</button>
                    </div>
                </div>
            </form>
        </li>
    </ul>
</div>


<script src="{{ asset('js/scripts.js') }}"></script>
@endsection