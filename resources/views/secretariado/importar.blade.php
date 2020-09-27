@extends('layouts.admin')

@section('main-content')

@include('layouts.mensajes')
<script>
    $(function() {
        $('#proce').hide();

        $('#f_procesar').submit(function() {
            $('#proce').show();
        })
    })
    
</script>

<div class="container" style="padding-top: 80px">
    <div class="row">
        <div class="col-md-11">
            <h4>Importar archivo con los datos del padron general de UOM recibido del secretariado</h4>
        </div>
    </div>
    <br />
    <form id="f_procesar" method="POST" enctype="multipart/form-data" action="{{route('secretariado.guardar')}}">
        @csrf

        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <label for="file">Seleccione un archivo Excel (xlsx)</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control-sm" name="path" id="path">
                            <label class="custom-file-label form-control-sm" for="path">nombre de archivo ...</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <input type="submit" class="btn btn-info" value="Comenzar a importar los datos" />
                <i id='proce' class="fas fa-spinner fa-pulse"></i>
            </div>
        </div>
    </form>
</div>

@endsection