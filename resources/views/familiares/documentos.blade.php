@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        <a href="{{ route('familiares.index', [$afiliado_id, $grupo_familiar_id]) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        Datos Generales
    </div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item">
            <form id='formEmp' action="{{ route('familiares.documentos.guardar') }}" method="POST"  accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">

                @csrf
                <input type='hidden' name='grupo_familiar_id' value="{{ $grupo_familiar_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Tipo de documento</label>
                            <select name="tipo_documento_id" id="tipo_documento_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($tipos_documentos as $dato)
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha Vencimiento</label>
                            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" class="form-control form-control-sm" />
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <input type="text" id="" name="obs" class="form-control form-control-sm" value="{{ old('obs') }}" maxlength="50" />
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="file">Archivo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input form-control-sm" name="path" id="path">
                                    <label class="custom-file-label form-control-sm" for="path">nombre de archivo ...</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group pad-20">
                            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo documento'))
                            <button type="submit" id="agregarpregunta" class="btn btn-success btn-sm float-right">Agregar</button>
                            @endif
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
                            @foreach($gf_documentos as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tipos_documentos->descripcion }}</td>
                                <td>{{ $item->fecha_vencimiento }}</td>
                                <td>{{ $item->obs }}</td>                          
                                <td>
                                    <div class="float-right">
                                        <a href="{{ route('familiares.download', $item->id) }}" data-toggle="tooltip" class="btn btn-primary btn-sm" title="Descargar documento"><i class="fas fa-file-download"></i> </a>
                                        <!-- <a href="{{ asset('storage/ ') . str_replace('public', '', $item->path) }}" data-toggle="tooltip" class="btn btn-primary btn-sm" title="Descargar documento"><i class="fas fa-file-download"></i> </a> -->
                                        <form action="{{ route('familiares.documentos.borrar', $item->id) }}" method="POST" style="display:inline">
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
                    <div class="pagination-wrapper"> {!! $gf_documentos->appends(['search' => Request::get('search')])->render() !!} </div>
                    <!-- @endif -->
                </div>
            </div>
        </li>
    </ul>
</div>



@endsection