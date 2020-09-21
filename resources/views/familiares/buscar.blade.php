@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        @if($afiliado_id == 0)
        <a href="{{ route('afiliado.index') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        @else
        <a href="{{ route('afiliado.find', $afiliado_id) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        @endif
        Datos a buscar de familiares
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <form id='formEmp' action="{{route('familiares.buscar')}}" method="GET">

                <input type='hidden' name='afiliado_id' value="{{ $afiliado_id }}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Apellido y nombre</label>
                            <input type="text" id="apellido_nombres" name="apellido_nombres" class="aMayusculas form-control form-control-sm" value="" maxlength="150" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text" id="nro_doc" name="nro_doc" class="solonros form-control form-control-sm" value="" data-toggle="tooltip" data-placement="top" title="DNI del familiar">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Parentesco</label>
                            <select name="tipo_parentesco_id" id="tipo_parentesco_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($tipos_parentescos as $dato)
                                <option value="{{$dato->id}}" {{(empty($registro->tipo_parentesco_id) ? old('tipos_parentescos') : $registro->tipo_parentesco_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Doc. pendiente</label>
                            <input type="date" id="docum_pendiente" name="docum_pendiente" class="form-control form-control-sm" value="" type="text" data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Doc. entregada</label>
                            <input type="date" id="docum_entregada" name="docum_entregada" class="form-control form-control-sm" value="" data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Nacionalidad</label>
                            <select name="nacionalidad_id" id="nacionalidad_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($nacionalidades as $dato)
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="">Provincia</label>
                            <select name="provincia_id" id="provincia_id" data-localidad='localidad_id' class="provincia form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($provincias as $dato)
                                <option value="{{$dato->id}}">{{$dato->nombre . ' - ' . $dato->cod_postal }}</option>
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
                            <label>Fec. baja</label>
                            <input type="date" id="fecha_egreso_sind" name="fecha_egreso_sind" class="form-control form-control-sm" value="" data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Motivo baja</label>
                            <select name="motivo_egreso_sind_id" id="motivo_egreso_sind_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($motivos_egresos_sind as $dato)
                                <option value="{{$dato->id}}" {{(empty($registro->motivo_egreso_sind_id) ? old('motivo_egreso_sind') : $registro->motivo_egreso_sind_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Discapacitado</label>
                        <div class="container" data-toggle="tooltip" data-placement="top" title="Si tilda una de las opciones buscará afiliados que sean o no sean discapacitados">
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="S" name="discapacitado">SI</input>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" value="N" name="discapacitado">NO</input>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Vto. certifidado</label>
                            <input type="date" id="fecha_venc_disca" name="fecha_venc_disca" class="form-control form-control-sm" value="{{ (empty($registro->fecha_venc_disca) ? old('fecha_venc_disca') : $registro->fecha_venc_disca) }}">
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