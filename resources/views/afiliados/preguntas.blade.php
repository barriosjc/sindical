@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<div class="card">
    <div class="card-header">
        <a href="{{ url('/afiliados/find/' . $afiliado_id) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
        Datos Generales
    </div>
    <ul class="list-group list-group-flush">

        <li class="list-group-item">
            <form id='formEmp' action="{{route('afiliado.preguntas.guardar')}}" method="POST">

                @csrf
                <input type='hidden' name='afiliado_id' value="{{ $afiliado_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Pregunta</label>
                            <select name="pregunta_id" id="pregunta_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($preguntas as $dato)
                                <option value="{{$dato->id}}" {{ old('pregunta_id') == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Respuesta</label>
                            <input type="text" id="" name="respuesta" class="form-control form-control-sm" value="{{ old('respuesta') }}" maxlength="50" />
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <input type="text" id="" name="obs" class="form-control form-control-sm" value="{{ old('obs') }}" maxlength="50" />
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group pad-20">
                            @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo afiliado'))
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
                                <th>Pregunta</th>
                                <th>Respuesta</th>
                                <th>Observaciones</th>
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($afil_preguntas as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->respuesta }}</td>
                                <td>{{ $item->obs }}</td>
                                <td>
                                    @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nuevo afiliado'))
                                    <div class="float-right">
                                        <form action="{{ route('afiliado.preguntas.borrar', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confima la eliminación?')"> <i class="far fa-trash-alt text-white"></i></button>
                                        </form>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- @if(!empty($afil_preguntas)) -->
                    <div class="pagination-wrapper"> {!! $afil_preguntas->appends(['search' => Request::get('search')])->render() !!} </div>
                    <!-- @endif -->
                </div>
            </div>
        </li>
    </ul>
</div>



@endsection