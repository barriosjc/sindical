@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        <a href="{{ url('/afiliados/find/' . $afiliado_id) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        Empresas que trabajo el afiliado
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <form id='formEmp' action="{{route('afiliado.empresas.guardar')}}" method="POST"  accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='afiliado_id' value="{{ $afiliado_id }}">
                <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Seccional</label>
                                <select name="seccional_id" id="seccional_id" class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($seccionales as $dato)
                                    <option value="{{$dato->id}}" {{ (empty($empresa_afil->seccional_id) ? old('seccional_id') : $empresa_afil->seccional_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Categoria</label>
                                <select name="categoria_id" id="categoria_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($categorias as $dato)
                                    <option value="{{$dato->id}}" {{    (empty($empresa_afil->categoria_id) ? old('categoria_id') : $empresa_afil->categoria_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Especialidad</label>
                                <select name="especialidad_id" id="especialidad_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($especialidades as $dato)
                                    <option value="{{$dato->id}}" {{(empty($empresa_afil->especialidad_id) ? old('especialidad_id') : $empresa_afil->especialidad_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. afiliación</label>
                                <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control form-control-sm" value="{{  old('fecha_ingreso', $empresa_afil->fecha_ingresoy) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_egreso" name="fecha_egreso" class="colorear form-control form-control-sm" value="{{ old('fecha_egreso', $empresa_afil->fecha_egresoy) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Motivo baja Sindical</label>
                                <select name="motivo_egreso_id" id="motivo_egreso_id" class="colorear form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    <!-- @foreach($motivos_egresos_sind as $dato)
                                    <option value="{{$dato->id}}" {{(empty($empresa_afil->motivo_egreso_id) ? old('motivos_egresos_sind') : $empresa_afil->motivo_egreso_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach -->
                                </select>
                            </div>
                       </div>
                    </div>                    
                </div>
            </form>
         </li>
        <li class="list-group-item">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo docum.</th>
                                <th>Fecha Vto.</th>
                                <th>Observaciones</th>
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($afil_documentos as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->fecha_vencimiento }}</td>
                                <td>{{ $item->obs }}</td>
                                <td>
                                    <div class="float-right">
                                        <a href="{{ route('afiliado.download', $item->id) }}" data-toggle="tooltip" class="btn btn-primary btn-sm" title="Descargar documento"><i class="fas fa-file-download"></i> </a>
                                        <form action="{{ route('afiliado.documentos.borrar', $item->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"> <i class="far fa-trash-alt text-white" onclick="return confirm('Confima la eliminación?')"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- @if(!empty($afil_preguntas)) -->
                    <div class="pagination-wrapper"> {!! $afil_documentos->appends(['search' => Request::get('search')])->render() !!} </div>
                    <!-- @endif -->
                </div>
            </div>
        </li>
    </ul>
</div>



@endsection