@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        <a href="{{ url('/afiliados/find/' . $afiliado_id) }}" title="Volver"><button class="btn btn-warning btn-sm"><i
                    class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        @if (!empty($afil_emp->id) )
        <a href="{{ route('afiliado.empresas',  [$afiliado_id]) }}" title="Limpiar"><button class="btn btn-warning btn-sm">
                Limpiar</button></a>
        @endif
        Empresas que trabajó el afiliado -> {{ $afiliado_nombre }}
    </div>
    <ul class="list-group list-group-flush">
        <form id='formEmp' action="{{route('afiliado.empresas.guardar')}}" method="POST" accept-charset="UTF-8"
            class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <li class="list-group-item">
                <input type='hidden' name='id' value="{{ $afil_emp->id }}">            
                <input type='hidden' name='afiliado_id' value="{{ $afiliado_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Seccional</label>
                            <select name="seccional_id" id="seccional_id" class="form-control form-control-sm"
                                style="width: 100%" required>
                                <option value="">--Seleccione--</option>
                                @foreach($seccionales as $dato)
                                <option value="{{$dato->id}}"
                                    {{old("seccional_id", $afil_emp->seccional_id) == $dato->id ? 'selected' : ''}}>
                                    {{ $dato->descripcion }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Categoria</label>
                            <select name="categoria_id" id="categoria_id" class="form-control form-control-sm"
                                style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($categorias as $dato)
                                <option value="{{$dato->id}}"
                                    {{old("categoria_id", $afil_emp->categoria_id) == $dato->id ? 'selected' : ''}}>
                                    {{$dato->descripcion}} </option>
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
                                    {{old("especialidad_id", $afil_emp->especialidad_id) == $dato->id ? 'selected' : ''}}>
                                    {{$dato->descripcion}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fec. afiliación</label>
                            <input type="date" id="fecha_ingreso" name="fecha_ingreso"
                                class="form-control form-control-sm"
                                value="{{  old('fecha_ingreso', $afil_emp->fecha_ingresoy) }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fec. baja</label>
                            <input type="date" id="fecha_egreso" name="fecha_egreso"
                                class="colorear form-control form-control-sm"
                                value="{{ old('fecha_egreso', $afil_emp->fecha_egresoy) }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Motivo baja Sindical</label>
                            <select name="motivo_egreso_id" id="motivo_egreso_id"
                                class="colorear form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($motivos_egresos_sind as $dato)
                                <option value="{{$dato->id}}"
                                    {{old("motivo_egreso_id", $afil_emp->motivo_egreso_id) == $dato->id ? 'selected' : ''}}>
                                    {{$dato->descripcion}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class='float-right pad-20'>
                            @if (Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo afiliado'))
                            <button type="submit" id="btnAgr" class="btn btn-info">Guardar datos</button>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Empresa</label>
                            <select name="empresa_id" id="empresa_id" class="busqueda form-control form-control-sm"
                                style="width: 100%" required>
                                <option value="">--Seleccione--</option>
                                @foreach($empresas as $dato)
                                <option value="{{$dato->id}}"
                                    {{old("empresa_id", $afil_emp->empresa_id) == $dato->id ? 'selected' : ''}}>
                                    {{$dato->razon_social}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fec. ingreso</label>
                            <input type="date" id="fecha_ing_empr" name="fecha_ing_empr"
                                class="form-control form-control-sm"
                                value="{{ old('fecha_ing_empr', $afil_emp->fecha_ing_empry) }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fec. baja</label>
                            <input type="date" id="fecha_egr_empr" name="fecha_egr_empr"
                                class="form-control form-control-sm"
                                value="{{ old('fecha_egr_empr', $afil_emp->fecha_egr_empry) }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Delegado desde</label>
                            <input type="date" id="delegado_desde" name="delegado_desde"
                                class="form-control form-control-sm"
                                value="{{ old('delegado_desde', $afil_emp->delegado_desdey) }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Delegado hasta</label>
                            <input type="date" id="delegado_hasta" name="delegado_hasta"
                                class="form-control form-control-sm"
                                value="{{ old('delegado_hasta', $afil_emp->delegado_hastay) }}">
                        </div>
                    </div>
                </div>
            </li>
        </form>
        <li class="list-group-item">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Seccional</th>
                                <th>Razon social</th>
                                <th>Fecha ingreso</th>
                                <th>Fecha egreso</th>
                                <th>Motivo egreso</th>
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empresas_afil as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->sec_desc }}</td>
                                <td>{{ $item->razon_social }}</td>
                                <td>{{ $item->fecha_ingreso }}</td>
                                <td>{{ $item->fecha_egreso }}</td>
                                <td>{{ $item->mot_desc }}</td>
                                <td>
                                    <div class="float-right">
                                        <a href="{{ route('afiliado.empresas', [ $afiliado_id, $item->id]) }}"
                                            class="btn btn-success btn-sm" title="Consultar datos."><i class="fa fa-eye"
                                                aria-hidden="true"></i></a>
                                        @if($loop->iteration > 1)
                                        <form action="{{ route('afiliado.empresas.borrar', $item->id) }}" method="POST"
                                            style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"> <i
                                                    class="far fa-trash-alt text-white"
                                                    onclick="return confirm('Confima la eliminación?')"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"> {{ $empresas_afil->appends(Request::all())->render() }} </div>
                </div>
            </div>
        </li>
    </ul>
</div>



@endsection