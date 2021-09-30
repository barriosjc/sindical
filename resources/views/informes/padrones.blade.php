@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')

<script>
    $(function() {
        $('#proce').hide();

        $('#f_procesar').submit(function() {
            $('#proce').show();    
            setTimeout(function(){
                $('#proce').hide();
            },7000);
        });
    });

</script>


<div class="container" style="padding-top: 80px">
    <div class="row">
        <div class="col-md-11">
            <h4>Seleccione de la lista el informe con el cual va a trabajar</h4>
        </div>
    </div>
    <br />
    <form id="f_procesar" method="POST" enctype="multipart/form-data" action="{{route('informes.generar')}}">
        @csrf
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="file">Informe</label>
                    <select name="informe" id="informe" class="form-control form-control-sm" style="width: 100%" required>
                        <option value="">--Seleccione--</option>
                        @foreach($informes as $clave => $dato)
                            <option value={{$clave}} >{{$dato}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <input type="submit" class="btn btn-info" value="Seleccionar" />
                <i id='proce' class="fas fa-spinner fa-pulse"></i>
            </div>
        </div>
    </form>
</div>

@endsection

