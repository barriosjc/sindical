@extends('layouts.admin')

@section('main-content')


<div class="card">
    <div class="card-header">

    <a href="{{ route('empresa.buscar.index', 0) }}" title="Volver"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</button></a>

      Resultados de la busqueda ({{$empresas->total()}}) empresas
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Apellido y nombres</th>
                                <th style="width:12%">CUIT</th>
                                <th>Empresa</th>
                                <th>Actividad</th>
                                <th>Estado</th>
                                <th style="width:8%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empresas as $item)
                            <tr @if(!empty($item->fecha_baja)) class="table-danger" @endif >
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->razon_social }}</td>
                                <td>{{ $item->cuit }}</td>
                                <td>{{ $item->cod_empresa }}</td>
                                <td>{{ $item->tipo_actividad }}</td>
                                <td>{{ $item->estado_desc }}</td>
                                <td>
                                    <div class="float-right">
                                        <form action="{{ route('empresa.find', $item->id) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm"> <i class="fas fa-edit"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"> {{ $empresas->appends(Request::all())->render() }} </div>
                </div>
            </div>
        </li>
    </ul>
</div>


@endsection