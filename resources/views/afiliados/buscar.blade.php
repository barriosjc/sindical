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

<div class="card">
    <div class="card-header">
    @if($afiliado_id == 0)
        <a href="{{ url('/afiliados') }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
    @else
        <a href="{{ url('/afiliados/find/' . $afiliado_id) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>
    @endif
    Datos a buscar
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <form id='formEmp' action="{{route('afiliado.buscar')}}" method="get">

                <input type='hidden' name='afiliado_id' value="{{ $afiliado_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">estado</label>
                            <select name="afil_estado_ficha_id" id="afil_estado_ficha_id" class="form-control form-control-sm" style="width: 100%" >
                                <option value="">--Seleccione--</option>
                                @foreach($estados as $dato)
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Apellido y nombre</label>
                            <input type="text" id="apellido_nombres" name="apellido_nombres" class="aMayusculas form-control form-control-sm" value="" maxlength="150" />
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
                            <input type="date" id="docum_entregada" name="docum_entregada" class="form-control form-control-sm" value=""  data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
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
                            <select name="provincia_id" id="provincia_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($provincias as $dato)
                                <option value="{{$dato->id}}">{{$dato->nombre}}</option>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Seccional</label>
                            <select name="seccional_id" id="seccional_id" class="form-control form-control-sm" style="width: 100%" >
                                <option value="">--Seleccione--</option>
                                @foreach($seccionales as $dato)
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Empresa</label>
                            <select name="empresa_id" id="empresa_id" class="form-control form-control-sm busqueda" style="width: 100%" >
                                <option value="">--Seleccione--</option>
                                @foreach($empresas as $dato)
                                <option value="{{$dato->id}}">{{$dato->nombre}}</option>
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
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
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
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fec. baja</label>
                            <input type="date" id="fecha_egr_empr" name="fecha_egr_empr" class="form-control form-control-sm" value="" data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Delegado hasta</label>
                            <input type="date" id="delegado_hasta" name="delegado_hasta" class="form-control form-control-sm" value="" data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Obra social</label>
                            <select name="obra_social_id" id="obra_social_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($obras_sociales as $dato)
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fec. baja</label>
                            <input type="date" id="fecha_egreso_os" name="fecha_egreso_os" class="form-control form-control-sm" value="" data-toggle="tooltip" data-placement="top" title="Se buscarán afiliados hasta la fecha ingresada aquí">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Motivo baja</label>
                            <select name="motivo_egreso_os_id" id="motivo_egreso_os_id" class="form-control form-control-sm" style="width: 100%">
                                <option value="">--Seleccione--</option>
                                @foreach($motivos_egresos_os as $dato)
                                <option value="{{$dato->id}}">{{$dato->descripcion}}</option>
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


<script>
    $(function() {

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

        $('.busqueda').select2({
            language: "es"
        });

    })
</script>

@endsection