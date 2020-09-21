@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        <a href="{{ route('denuncia.index') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        Datos a buscar de denuncias
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <form id='formEmp' action="{{ route('denuncia.buscar') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tipo de denuncia</label>
                            <select name="tipo_denuncia_id" id="tipo_denuncia_id" class="form-control form-control-sm" style="width: 100%" >
                                <option value="">--Seleccione--</option>
                                @foreach($tipos_denuncias as $dato)
                                <option value="{{$dato->id}}"> {{$dato->descripcion}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Tipo de movimiento inicial</label>
                            <select name="tipo_movimiento_id" id="tipo_movimiento_id" class="form-control form-control-sm" style="width: 100%" >
                                <option value="">--Seleccione--</option>
                                @foreach($tipos_movimientos as $dato)
                                <option value="{{$dato->id}}" >{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Ministerio</label>
                            <select name="ministerio_id" id="ministerio_id" class="form-control form-control-sm" style="width: 100%" >
                                <option value="">--Seleccione--</option>
                                @foreach($ministerios as $dato)
                                <option value="{{$dato->id}}" >{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha</label>
                            <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Denunciante/s</label>
                            <input type="text" id="nombre" name="nombre" class="aMayusculas form-control form-control-sm" maxlength="150" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Dirección denunciante</label>
                            <input type="text" id="direccion" name="direccion" class="aMayusculas form-control form-control-sm"  maxlength="150" />
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Empresa</label>
                            <input type="text" id="empresa" name="empresa" class="aMayusculas form-control form-control-sm"  maxlength="150" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>CUIT de empresa</label>
                            <input type="text" id="cuit" name="cuit" class="solonros form-control form-control-sm" maxlength="15" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Quién tomó la denuncia</label>
                            <input type="text" id="tomo_denuncia" name="tomo_denuncia" class="aMayusculas form-control form-control-sm"  maxlength="150" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Nro expediente</label>
                            <input type="text" id="numero_expediente" name="numero_expediente" class="solonros form-control form-control-sm" maxlength="15" />
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