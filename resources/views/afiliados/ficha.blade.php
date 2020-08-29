@extends('layouts.admin')

@section('main-content')

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

<form id='formEmp' action="{{route('afiliado.find')}}" method="GET">
    <div class="row bot-20  justify-content-end">
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" data-toggle="tooltip" data-placement="top" title="Ingrese un número de dni a buscar" placeholder="D.N.I." id="busdni" name="busdni" class="form-control form-control-sm" aria-describedby="buscar" maxlength="10">
                <input type="text" data-toggle="tooltip" data-placement="top" title="Ingrese un número de afiliado sindical" placeholder="Nro Afiliado" id="busnroafil" name="busnroafil" class="form-control form-control-sm" aria-describedby="buscar" maxlength="12">
                <div class="input-group-append">
                    <button class="btn btn-outline-primary btn-sm" type="submit" id="buscar"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id='formEmp' action="{{route('afiliado.guardar')}}" method="POST">
    @csrf
    <input type='hidden' id='id' name='id' value="{{$registro->id}}" />
    <div class="bot-20">
        <div class="card ">
            <div class="card-header">
                <a href="{{ route('afiliado.index') }}" class="btn btn-success btn-sm" title="Agregar"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo</a>
                Datos personales del titular
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">estado</label>
                                <select name="afil_estado_ficha_id" id="afil_estado_ficha_id" class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($estados as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->afil_estado_ficha_id) ? old('afil_estado_ficha_id') : $registro->afil_estado_ficha_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Doc. pendiente</label>
                                <input type="date" id="docum_pendiente" name="docum_pendiente" class="form-control form-control-sm" value="{{ old('docum_pendiente', $registro->docum_pendientey) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Doc. entregada</label>
                                <input type="date" id="docum_entregada" name="docum_entregada" class="form-control form-control-sm" value="{{   old('docum_entrega', $registro->docum_entregaday) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="">Nro Afiliado</label>
                            <div class="input-group" data-toggle="tooltip" data-placement="top" title="Presione el botón para obtener un número de afiliado, trae un dato solo si la casilla de texto esta en blanco.">
                                <input type="text" id="nro_afil_sindical" name="nro_afil_sindical" class="form-control form-control-sm" aria-describedby="signroafil" value="{{  old('nro_afil_sindical', $registro->nro_afil_sindical) }}" maxlength="12">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary btn-sm" id="signroafil"><i class="fas fa-sort-numeric-up"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="">CUIL</label>
                                <input type="text" id="" name="cuil" class="form-control form-control-sm" value="{{  old('cuil', $registro->cuil) }}" maxlength="13" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Apellido y nombre</label>
                                <input type="text" id="apellido_nombres" name="apellido_nombres" class="aMayusculas form-control form-control-sm" value="{{  old('apellido_nombres', $registro->apellido_nombres) }}" maxlength="150" />
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
                                <input type="date" id="fecha_nac" name="fecha_nac" class="form-control form-control-sm" value="{{ old('fecha_nac', $registro->fecha_nacy) }}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Edad</label>
                                <input type="text" id="edad" name="edad" class="form-control form-control-sm" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefonos</label>
                                <input type="text" id="" name="telefono1" class="form-control form-control-sm" value="{{ old('telefono1', $registro->telefono1) }}" maxlength="60" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="" name="email" class="form-control form-control-sm" value="{{ old('email', $registro->email) }}" maxlength="60" />
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
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
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones</label>
                                <input type="text" id="" name="calle_obs" class="form-control form-control-sm" value="{{ old('calle_obs', $registro->calle_obs) }}" maxlength="150" />
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bot-20">
        <div class="card">
            <div class="card-header">
                Datos laborales
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Seccional</label>
                                <select name="seccional_id" id="seccional_id" class="form-control form-control-sm" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($seccionales as $dato)
                                    <option value="{{$dato->id}}" {{ (empty($registro->seccional_id) ? old('seccional_id') : $registro->seccional_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
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
                                    <option value="{{$dato->id}}" {{    (empty($registro->categoria_id) ? old('categoria_id') : $registro->categoria_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
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
                                    <option value="{{$dato->id}}" {{(empty($registro->especialidad_id) ? old('especialidad_id') : $registro->especialidad_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. afiliación</label>
                                <input type="date" id="fecha_ingreso" name="fecha_ingreso_" class="form-control form-control-sm" value="{{  old('fecha_ingreso', $registro->fecha_ingresoy) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_egreso" name="fecha_egreso" class="form-control form-control-sm" value="{{ old('fecha_egreso', $registro->fecha_egresoy) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Motivo baja Sindical</label>
                                <select name="motivo_egreso_id" id="motivo_egreso_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($motivos_egresos_sind as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->motivo_egreso_id) ? old('motivos_egresos_sind') : $registro->motivo_egreso_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Empresa</label>
                                <select name="empresa_id" id="empresa_id" class="form-control form-control-sm busqueda" style="width: 100%" required>
                                    <option value="">--Seleccione--</option>
                                    @foreach($empresas as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->empresa_id) ? old('empresa_id') : $registro->empresa_id)  == $dato->id ? 'selected' : ''}}>{{$dato->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. afiliación</label>
                                <input type="date" id="fecha_ing_empr" name="fecha_ing_empr" class="form-control form-control-sm" value="{{ old('fecha_ing_empr', $registro->fecha_ing_empry) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_egr_empr" name="fecha_egr_empr" class="form-control form-control-sm" value="{{ old('fecha_egr_empr', $registro->fecha_egr_empry) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Delegado desde</label>
                                <input type="date" id="delegado_desde" name="delegado_desde" class="form-control form-control-sm" value="{{ old('delegado_desde', $registro->delegado_desdey) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Delegado hasta</label>
                                <input type="date" id="delegado_hasta" name="delegado_hasta" class="form-control form-control-sm" value="{{ old('delegado_hasta', $registro->delegado_hastay) }}">
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bot-20">
        <div class="card">
            <div class="card-header">
                Datos de Obra social
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="">Obra social</label>
                                <select name="obra_social_id" id="obra_social_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($obras_sociales as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->obra_social_id) ? old('obra_social_id') : $registro->obra_social_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. afiliación</label>
                                <input type="date" id="fecha_ingreso_os" name="fecha_ingreso_os" class="form-control form-control-sm" value="{{ old('fecha_ingreso_os', $registro->fecha_ingreso_osy) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Fec. baja</label>
                                <input type="date" id="fecha_egreso_os" name="fecha_egreso_os" class="form-control form-control-sm" value="{{ old('fecha_egreso_os', $registro->fecha_egreso_osy) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Motivo baja</label>
                                <select name="motivo_egreso_os_id" id="motivo_egreso_os_id" class="form-control form-control-sm" style="width: 100%">
                                    <option value="">--Seleccione--</option>
                                    @foreach($motivos_egresos_os as $dato)
                                    <option value="{{$dato->id}}" {{(empty($registro->motivo_egreso_os_id) ? old('motivo_egreso_os_id') : $registro->motivo_egreso_os_id)  == $dato->id ? 'selected' : ''}}>{{$dato->descripcion}}</option>
                                    @endforeach
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
                                <label>Fec. jubilacón</label>
                                <input type="date" id="fecha_jubilacion" name="fecha_jubilacion" class="form-control form-control-sm" value="{{ old('fecha_jubilacion', $registro->fecha_jubilaciony) }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Nro benef. Anses</label>
                                <input type="text" id="" name="nro_ben_anses" class="form-control form-control-sm" value="{{ old('nro_ben_anses', $registro->nro_ben_anses) }}" maxlength="10" />
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="bot-20">
        <div class="card">
            <div class="card-header">
                Datos Generales
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Observaciones generales</label>
                                <input type="text" id="" name="obs_gral" class="form-control form-control-sm" value="{{ old('obs_gral', $registro->obs_gral) }}" maxlength="500" />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="e" class="form-control form-control-sm text-center bg-gradient-light ">Usuario : {{ $registro->user_last_name }} / Ult. modif. : {{ $registro->updated_at }} </label>
                        </div>
                    </div>
                </li>

                <li class="list-group-item">
                    <div class='row'>
                        <div class="col-md-8 float-right" >
                            @if(isset($registro->id))
                            <a href=" {{ route('afiliado.documentos', $registro->id) }} " id="btnfoto" class="btn btn-primary">Documentación <span class="badge badge-light">{{$cantidades['documentos']}}</span></a>
                            <a href=" {{ route('afiliado.carnet', $registro->id) }} " id="btncarnet" class="btn btn-primary">Carnet <span class="badge badge-light">{{$cantidades['foto']}}</span></a>
                            <a href=" {{ route('familiares.index', $registro->id) }} " id="btgrupofam" class="btn btn-primary">Grupo familiar <span class="badge badge-light">{{$cantidades['grupo_fam']}}</span></a>
                            <a href=" {{ route('afiliado.preguntas', $registro->id) }} " id="btnpreguntas" class="btn btn-primary">Preguntas <span class="badge badge-light">{{$cantidades['preguntas']}}</span></a>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <button type="submit" id="btnAgr" class="btn btn-info float-right">Guardar datos</button>
                            <a href="{{ route('afiliado.buscar.index', isset($registro->id) ? $registro->id : 0) }}" id="btnbuscartit" class="btn btn-info float-right"><i class="fas fa-search"></i> Titular</a>
                            <a href="{{ route('familiares.buscar.index', isset($registro->id) ? $registro->id : 0) }}" id="btnbuscarfam" class="btn btn-info float-right"><i class="fas fa-search"></i> Familiar</a>
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