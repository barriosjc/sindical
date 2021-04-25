@extends('layouts.admin')

@section('main-content')


<div class="card">
    <div class="card-header">
        <a href="{{ url('/afiliados/find/' . $afiliado->id) }}" title="Volver"><button class="btn btn-warning btn-sm"><i
                    class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>

        Carnet del afiliado: {{$afiliado->apellido_nombres}}
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
        <div class="row">
                <div class="col-md-6">
                    <a href="{{ route('familiares.buscar.index', 0) }}" id="btnbuscarfam" class="btn btn-info"><i
                            class="fas fa-search"></i> Seleccionar foto</a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('familiares.buscar.index', 0) }}" id="btnbuscarfam" class="btn btn-info"><i
                            class="fas fa-search"></i> Tomar foto</a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                <img  class="img-foto" src="" alt="foto del afiliado" >
                </div>
                <div class="col-md-4">
                <a href="{{ route('familiares.buscar.index', 0) }}" id="btnbuscarfam" class="btn btn-info"><i
                            class="fas fa-search"></i>Guardar datos</a>
                            <a href="{{ route('familiares.buscar.index', 0) }}" id="btnbuscarfam" class="btn btn-info"><i
                            class="fas fa-search"></i>Generar Carnet</a>
                </div>
            </div>
        </li>
    </ul>
</div>


@endsection