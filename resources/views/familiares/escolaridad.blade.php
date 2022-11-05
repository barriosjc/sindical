@extends('layouts.admin')
@section('main-content')
@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        <a href="{{ route('familiares.index', [$afiliado_id, $grupo_familiar_id]) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        Entrega de útilies escolares
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <form id='formEmp' action="{{ route('familiares.escolaridad.guardar') }}" method="POST"  accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <input type='hidden' name='grupo_familiar_id' value="{{ $grupo_familiar_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Material a entregar</label>
                            <select name="tipo_material_id" id="tipo_material_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($tipos_material as $dato)
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="text" id="cantidad" name="cantidad" class="form-control form-control-sm" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <input type="text" id="" name="obs" class="form-control form-control-sm" value="{{ old('obs') }}" maxlength="50" />
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group pad-20">
                            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo escolaridad'))
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
                                <th>Material</th>
                                <th>Cantidad</th>
                                <th>Observaciones</th>                            
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gf_escolaridad as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tipos_material->descripcion }}</td>
                                <td>{{ $item->cantidad }}</td>
                                <td>{{ $item->obs }}</td>                          
                                <td>
                                    <div class="float-right">
                                        {{-- <a href="{{ asset('storage/ ') . str_replace('public', '', $item->path) }}" data-toggle="tooltip" class="btn btn-primary btn-sm" title="Descargar documento"><i class="fas fa-file-download"></i> </a> --}}
                                        <form action="{{ route('familiares.escolaridad.borrar', $item->id) }}" method="POST" style="display:inline">
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
                     {{-- @if(!empty($gf_escolaridad)) --}}
                    <div class="pagination-wrapper"> {!! $gf_escolaridad->appends(['search' => Request::get('search')])->render() !!} </div>
                     {{-- @endif  --}}
                </div>
            </div>
        </li>
    </ul>
</div>



@endsection