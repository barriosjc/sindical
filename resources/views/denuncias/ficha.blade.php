@extends('layouts.admin')

@section('main-content')

<div class="container-fluid sin-padding">
    @include('layouts.mensajes')
    <form id='formEmpbus' action="{{route('denuncia.find')}}" method="GET">
        <div class="row bot-20  justify-content-end">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" data-toggle="tooltip" data-placement="top" title="Ingrese un número de denuncia a buscar" placeholder="nro denuncia" id="busdenuncia" name="busdenuncia" class="solonros form-control form-control-sm" aria-describedby="buscar" maxlength="12">
                    <input type="text" data-toggle="tooltip" data-placement="top" title="Ingrese un número de v_ult_denuncias.nto" placeholder="Nro DNI" id="busnrodni" name="busnrodni" class="solonros form-control form-control-sm" aria-describedby="buscar" maxlength="12">
                    <div class="input-group-append">
                        <button class="btn btn-outline-primary btn-sm" type="submit" id="buscar"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form id='formEmp' action="{{route('denuncia.guardar')}}" method="POST">
        @csrf
        <input type='hidden' id='id' name='id' value="{{$registro->id}}" />
        <div class="bot-20">
            <div class="card ">
                <div class="card-header">
                    @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nueva denuncia'))
                    <a href="{{ route('denuncia.index') }}" class="btn btn-success btn-sm" title="Agregar nuevo Role"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo</a>
                    @endif
                    Datos completos de la denuncia
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="">Nro denuncia</label>
                                <div class="input-group" data-toggle="tooltip" data-placement="top" title="Presione el botón para obtener un número de denuncia, trae un dato solo si la casilla de texto esta en blanco.">
                                    <input type="text" id="numero" name="numero" data-tipo='NRO_DENUNCIA' class="valorsiguiente solonros form-control form-control-sm" aria-describedby="signroafil" value="{{  old('numero', $registro->numero) }}" maxlength="12">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary btn-sm" id="obtsiguiente"><i class="fas fa-sort-numeric-up"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form-control form-control-sm" value="{{ old('fecha_ingreso', $registro->fecha_ingresoy) }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Tipo de denuncia</label>
                                    <select name="tipo_denuncia_id" id="tipo_denuncia_id" class="form-control form-control-sm" style="width: 100%" required>
                                        <option value="">--Seleccione--</option>
                                        @foreach($tipos_denuncias as $dato)
                                        <option value="{{$dato->id}}" {{(empty($registro->tipo_denuncia_id) ? old('tipo_denuncia_id') : $registro->tipo_denuncia_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <input type='hidden' id='afiliado_id' name='afiliado_id' value="{{$registro->afiliado_id}}" />
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Nro DNI</label>
                                    <div class="input-group" data-toggle="tooltip" data-placement="top" title="Ingrese el nro de DNI y luego presione el botón, si encuentra los datos cargará el nombre y demas datos.">
                                        <input type="text" id="nro_dni" name="nro_dni" class="solonros form-control form-control-sm" aria-describedby="signroafil" value="{{  old('nro_dni', $registro->nro_dni) }}" maxlength="10">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-sm" id="buscaafil"><i class="far fa-hand-point-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" id="apellido_nombres" name="apellido_nombres" class="form-control form-control-sm" value="{{ old('apellido_nombres', $registro->apellido_nombres)  }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" id="direccion" name="direccion" class="form-control form-control-sm" value="{{ old('direccion', $registro->direccion) }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" id="telefono1" name="telefono1" class="form-control form-control-sm" value="{{ old('telefono1', $registro->telefono1) }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Denunciante/s</label>
                                    <input type="text" id="nombre" name="nombre" class="aMayusculas form-control form-control-sm" value="{{ old('nombre', $registro->nombre) }}" maxlength="150" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Dirección denunciante</label>
                                    <input type="text" id="direccion" name="direccion" class="aMayusculas form-control form-control-sm" value="{{ old('direccion', $registro->direccion) }}" maxlength="150" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Empresa</label>
                                    <input type="text" id="empresa" name="empresa" class="aMayusculas form-control form-control-sm" value="{{ old('empresa', $registro->empresa) }}" maxlength="150" />
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>CUIT</label>
                                    <input type="text" id="cuit" name="cuit" class="solonros form-control form-control-sm" value="{{ old('cuit', $registro->cuit) }}" maxlength="15" />
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Dirección empresa</label>
                                    <input type="text" id="direccion_empr" name="direccion_empr" class="aMayusculas form-control form-control-sm" value="{{ old('direccion_empr', $registro->direccion_empr) }}" maxlength="150" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Texto denuncia</label>
                                    <textarea rows="5" id="descripcion" name="descripcion" class="form-control form-control-sm"> {{ old('descripcion', $registro->descripcion) }} </textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Quién tomó la denuncia</label>
                                    <input type="text" id="tomo_denuncia" name="tomo_denuncia" class="aMayusculas form-control form-control-sm" value="{{ old('tomo_denuncia', $registro->tomo_denuncia) }}" maxlength="150" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo de movimiento inicial</label>
                                    <select name="tipo_movimiento_id" id="tipo_movimiento_id" class="form-control form-control-sm" style="width: 100%" required>
                                        <option value="">--Seleccione--</option>
                                        @foreach($tipos_movimientos as $dato)
                                        <option value="{{$dato->id}}" {{(empty($registro->tipo_movimiento_id) ? old('tipo_movimiento_id') : $registro->tipo_movimiento_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de movimiento actual</label>
                                    <input type="text" id="tipo_movimiento_desc" name="tipo_movimiento_desc" class="form-control form-control-sm" value="{{ $tipo_movimiento_desc }}" disabled />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea rows="3" id="obs" name="obs" class="form-control form-control-sm">{{ old('obs', $registro->obs) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Nro expediente</label>
                                    <input type="text" id="numero_expediente" name="numero_expediente" class="solonros form-control form-control-sm" value="{{ old('numero_expediente', $registro->numero_expediente) }}" maxlength="15" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ministerio</label>
                                    <select name="ministerio_id" id="ministerio_id" class="form-control form-control-sm" style="width: 100%" required>
                                        <option value="">--Seleccione--</option>
                                        @foreach($ministerios as $dato)
                                        <option value="{{$dato->id}}" {{(empty($registro->ministerio_id) ? old('ministerio_id') : $registro->ministerio_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
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
                                    <a href=" {{ route('denuncia.documentos',  $registro->id) }} " id="btndocum" class="btn btn-primary">Documentación <span class="badge badge-light">{{$cantidades['documentos']}}</span></a>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class='float-right'>
                                    <a href="{{ route('denuncia.buscar.index', isset($registro->id) ? $registro->id : 0) }}" id="btnbuscar" class="btn btn-info"><i class="fas fa-search"></i> Buscar</a>
                                    @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nueva denuncia'))
                                    <button type="submit" id="btnguardarfam" class="btn btn-info">Guardar datos</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

    </form>

    @if(!empty($registro->id))

    <div class="bot-20">
        <div class="card ">
            <div class="card-header">
                Movimientos de denuncias
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo movimiento</th>
                                    <th>Fecha</th>
                                    <th>Observaciones</th>
                                    <th>Usuario</th>
                                    <th style="width:8%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($denuncias_det as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tipos_movimientos->descripcion }}</td>
                                    <td>{{ $item->fecha }}</td>
                                    <td>{{ $item->obs }}</td>
                                    <td>{{ $item->user_last_name }}</td>
                                    <td>
                                        @if($loop->iteration > 1)
                                        <div class="float-right">
                                            <form action="{{ route('denuncia.borrar.movimiento', $item->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"> <i class="far fa-trash-alt text-white" onclick="return confirm('Confima la eliminación?')"></i></button>
                                            </form>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="pagination-wrapper"> {{ $denuncias_det->appends(Request::all())->render() }} </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <form id='formdet' action="{{ route('denuncia.guardar.movimiento', $registro->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tipo de movimiento actual</label>
                                    <select name="tipo_movimiento_id_det" id="tipo_movimiento_id_det" class="form-control form-control-sm" style="width: 100%" required>
                                        <option value="">--Seleccione--</option>
                                        @foreach($tipos_movimientos as $dato)
                                        <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="date" id="fecha_ingreso_det" name="fecha_ingreso_det" class="form-control form-control-sm" }}">
                                </div>
                            </div>
                            <div class="col-md-6 pad-20">
                                <div class='float-right'>
                                    @if(Auth::user()->hasrole('administrador') or Auth::user()->haspermissionto('nueva denuncia'))
                                    <button type="submit" id="btnguardarfam" class="btn btn-info">Guardar movimiento</button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Observaciones</label>
                                    <textarea rows="3" id="obs_det" name="obs_det" class="form-control form-control-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    @endif


    <script src="{{ asset('js/scripts.js') }}"></script>

    <script type="text/javascript">
        $('#buscaafil').on('click', function(e) {
            e.preventDefault();
            if ($('#nro_dni').val() == '') {
                $('#apellido_nombres').val(null);
                $('#direccion').val(null);
                $('#telefono1').val(null);
                $('#afiliado_id').val(null);
                return false;
            }
            var $nro_dni = $('#nro_dni').val();
            $.get('/api/afiliado/' + $nro_dni + '/buscar', function() {
                    //   console.log(data);
                })

                .done(function(data) {
                    $('#apellido_nombres').val(data.apellido_nombres);
                    $('#direccion').val(data.direccion);
                    $('#telefono1').val(data.telefono1);
                    $('#afiliado_id').val(data.id);
                })
                .fail(function() {
                    $('#apellido_nombres').val(null);
                    $('#direccion').val(null);
                    $('#telefono1').val(null);
                    $('#afiliado_id').val(null);
                })


        });
    </script>


    @endsection