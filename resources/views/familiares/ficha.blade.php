@extends('layouts.admin')

@section('main-content')

<div class="container-fluid sin-padding">
    <div class="row">
        <div class="col-md-12">
            @if (session('mensaje'))
            <div class="alert alert-success">
                {{session('mensaje')}}
            </div>
            @endif

            <!-- muestra los msg de error de la validacion de campos en db -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <br />
            @endif
        </div>
    </div>

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
                        <tr >
                            <th>#</th>
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
                        <tr @if(isset($item->fecha_egreso_sind)) class="table-danger" @endif>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->apellido_nombres }}</td>
                            <td>{{ $item->nro_doc }}</td>
                            <td> {{$item->tipos_parentescos->descripcion }} </td>
                            <td>{{ date('d-m-Y', strtotime($item->fecha_nac)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->fecha_ingreso_sind)) }}</td>
                            <td>{{ date('d-m-Y', strtotime($item->fecha_egreso_sind)) }}</td>
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
</div>

<form id='formEmp' action="{{route('familiares.guardar')}}" method="POST">
    @csrf
    <input type='hidden' id='id' name='id' value="{{$registro->id}}" />
    <input type='hidden' id='afiliado_id' name='afiliado_id' value="{{$afiliado_id}}" />
    <div class="bot-20">
        <div class="card ">
            <div class="card-header">
                Datos personales
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Apellido y nombre</label>
                                <input type="text" id="apellido_nombres" name="apellido_nombres" class="aMayusculas form-control form-control-sm" value="{{  old('apellido_nombres', $registro->apellido_nombres) }}" maxlength="150" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Doc. pendiente</label>
                                <input type="date" id="docum_pendiente" name="docum_pendiente" class="form-control form-control-sm" value="{{  (empty($registro->docum_pendiente) ? old('docum_pendiente') : date('Y-m-d', strtotime( $registro->docum_pendiente))) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Doc. entregada</label>
                                <input type="date" id="docum_entregada" name="docum_entregada" class="form-control form-control-sm" value="{{  (empty($registro->docum_entregada) ? old('docum_entregada') : date('Y-m-d', strtotime( $registro->docum_entregada))) }}">
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
                                <input type="text" id="" name="cuil" class="form-control form-control-sm" value="{{  old('cuil', $registro->cuil) }}" maxlength="13" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Tipo Doc</label>
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
                                <label>Nro docum.</label>
                                <input type="text" id="" name="nro_doc" class="form-control form-control-sm" value="{{ old('nro_doc', $registro->nro_doc) }}" maxlength="12" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. Nac.</label>
                                <input type="date" id="fecha_nac" name="fecha_nac" class="form-control form-control-sm" value="{{ (empty($registro->fecha_nac) ? old('fecha_nac') : date('Y-m-d', strtotime( $registro->fecha_nac))) }}">
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
                                <label for="">Parentesco</label>
                                <select name="tipo_parentesco_id" id="tipo_parentesco_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($tipos_parentescos as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->tipo_parentesco_id) ? old('tipos_parentescos') : $registro->tipo_parentesco_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
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
                                <select name="provincia_id" id="provincia_id" class="form-control form-control-sm" style="width: 100%">
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
                                    @if($localidades != null){
                                    <option value="{{$localidades->id}}">{{$localidades->nombre}}</option>
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
                                    <option value="{{$dato->id}}" {{(empty($registro->nacionalidad_id) ? old('nacionalidades') : $registro->nacionalidad_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
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
                                    <option value="{{$dato->id}}" {{(empty($registro->estado_civil_id) ? old('estado_civil') : $registro->estado_civil_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">Sexo</label>
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
                                <input type="date" id="fecha_venc_disca" name="fecha_venc_disca" class="form-control form-control-sm" value="{{ (empty($registro->fecha_venc_disca) ? old('fecha_venc_disca') : date('Y-m-d', strtotime( $registro->fecha_venc_disca))) }}">
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
                                <input type="date" id="fecha_ingreso_sind" name="fecha_ingreso_sind" class="form-control form-control-sm" value="{{ (empty($registro->fecha_ingreso_sind) ? old('fecha_ingreso_sind') : date('Y-m-d', strtotime( $registro->fecha_ingreso_sind))) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_egreso_sind" name="fecha_egreso_sind" class="form-control form-control-sm" value="{{ (empty($registro->fecha_egreso_sind) ? old('fecha_egreso_sind') : date('Y-m-d', strtotime( $registro->fecha_egreso_sind))) }}">
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

                        <div class="col-md-12">
                            <label for="e" class="form-control form-control-sm text-center bg-gradient-light ">Usuario : {{ $registro->user_last_name }} / Ult. modif. : {{ $registro->updated_at }} </label>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class='row'>
                        <div class="col-md-8">
                            @if(isset($registro->id))
                            <a href=" {{ route('familiares.documentos', $registro->id) }} " id="btnfoto" class="btn btn-primary float-right">Documentación <span class="badge badge-light">{{$cantidades['documentos']}}</span></a>
                            <button type="button" id="btnfoto" class="btn btn-primary float-right">Foto <span class="badge badge-light">{{$cantidades['foto']}}</span></button>
                             @endif
                        </div>

                        <div class="col-md-4">
                            <button type="submit" id="btnAgr" class="btn btn-info float-right">Guardar datos</button>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>

</form>


<script>
    $(function() {

        $('#signroafil').on('click', function(e) {
            e.preventDefault();

            if ($('#nro_afil_sindical').val() != '') {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ route('afiliado.siguiente') }}",
                method: 'get',
                // data: {
                //     content: jQuery('#nro_afil_sindical').val()
                // },
                success: function(result) {
                    // console.log(result.success);
                    $('#nro_afil_sindical').val(result.success);
                }
            });
        });

        $('#provincia_id').on('change', function() {

            var prov_id = $(this).val();
            var html_select = '';
            if (!prov_id) {
                $('#localidad_id').html('<option value="">--Seleccione--</option>');
                return
            }
            $.get('/api/provincia/' + prov_id + '/localidades', function(data) {
                for (var i = 0; i < data.length; ++i) {
                    html_select += '<option value="' + data[i].id + '">' + data[i].nombre + ' - ' + data[i].cod_postal + '</option>';
                }
                $('#localidad_id').html(html_select);
            })
        })


        $('[data-toggle="tooltip"]').tooltip()

        $(".aMayusculas").on("keyup", function() {
            this.value = this.value.toUpperCase();
        })


        if ($('#fecha_nac').val() != '') {
            calcularEdad($('#fecha_nac').val());
        }

        $('#fecha_nac').on('change', function() {
            calcularEdad($('#fecha_nac').val());
        });

        $('.busqueda').select2({
            language: "es"
        });

        function calcularEdad(e) {
            // fecha = $(this).val();
            fecha = e;
            var hoy = new Date();
            var cumpleanos = new Date(fecha);
            var edad = hoy.getFullYear() - cumpleanos.getFullYear();
            var m = hoy.getMonth() - cumpleanos.getMonth();

            if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
                edad--;
            }
            $('#edad').val(edad);
        }
    })
</script>

@endsection